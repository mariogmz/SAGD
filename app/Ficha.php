<?php

namespace App;


use Illuminate\Support\Facades\DB;
use Sagd\IcecatFeed;

/**
 * App\Ficha
 *
 * @property integer $id
 * @property integer $producto_id
 * @property string $calidad
 * @property string $titulo
 * @property boolean $revisada
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Producto $producto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\FichaCaracteristica[] $caracteristicas
 * @method static \Illuminate\Database\Query\Builder|\App\Ficha whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ficha whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ficha whereCalidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ficha whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ficha whereRevisada($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ficha whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ficha whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ficha whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Galeria[] $galerias
 */
class Ficha extends LGGModel {

    protected $table = "fichas";
    public $timestamps = true;
    protected $fillable = ['producto_id', 'calidad', 'titulo', 'revisada'];

    public static $rules = [
        'producto_id' => 'integer|required|unique:fichas',
        'calidad'     => "string|max:45|in:INTERNO,FABRICANTE,ICECAT,NOEDITOR",
        'titulo'      => 'string|required|max:50',
        'revisada'    => 'boolean'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Ficha::creating(function ($model) {
            return $model->isValid();
        });
        Ficha::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['producto_id'] = 'integer|required|unique:fichas,producto_id,' . $model->id;

            return $model->isValid('update');
        });
    }

    /**
     * Este método recibe el array extraído de una ficha de icecat e inicializa una ficha para un producto junto
     * con sus características, si la bandera de sobreescribir está en TRUE, sobrescribe las descripciones del producto
     * @param $sheet
     * @param bool|false $sobrescribir_datos_producto
     * @return array|bool|\Illuminate\Database\Eloquent\Collection
     */
    private function guardarFichaConDetalles($sheet, $sobrescribir_datos_producto = false) {
        // Guardar datos de la ficha
        $calidad = strtoupper(trim($sheet['quality']));
        $this->calidad = in_array($calidad, ['INTERNO', 'FABRICANTE', 'ICECAT', 'NOEDITOR']) ? $calidad : null;
        $this->titulo = $sheet['title'];

        $icecat_category_id = $sheet['icecat_category_id'];

        // Guardar características
        $fichas_caracteristicas = [];
        foreach ($sheet['features'] as $caracteristica) {
            $category_feature =
                IcecatCategoryFeature::where('icecat_category_id', $icecat_category_id)
                    ->where('icecat_category_feature_group_id', $caracteristica['icecat_category_feature_group_id'])
                    ->where('icecat_feature_id', $caracteristica['icecat_feature_id'])
                    ->first(['id']);

            if (!empty($caracteristica['value']) && !empty($category_feature)) {
                $ficha_caracteristica = new FichaCaracteristica([
                    'category_feature_id' => $category_feature->id,
                    'valor'               => $caracteristica['value'],
                    'valor_presentacion'  => $caracteristica['presentation_value']
                ]);
                array_push($fichas_caracteristicas, $ficha_caracteristica);
            }
        }

        if ($this->save()) {
            if ($sobrescribir_datos_producto) {
                $nuevos_valores = [];
                $icecat_category = IcecatCategory::whereIcecatId($icecat_category_id)->first();
                if (!empty($icecat_category)) {
                    $nuevos_valores = array_merge($nuevos_valores, ['subfamilia_id' => $icecat_category->subfamilia_id]);
                }
                $this->producto->update(array_merge($nuevos_valores, [
                    'descripcion'       => substr($sheet['long_summary_description'], 0, 299),
                    'descripcion_corta' => substr($sheet['short_summary_description'], 0, 49)
                ]));
            }

            return $this->caracteristicas()->saveMany($fichas_caracteristicas);
        } else {
            return false;
        }
    }

    /**
     * Este método recibe los datos de una ficha para un producto desde icecat, busca si existen las características
     * en la base de datos y si existen, actualiza sus valores, si no, los agrega
     * @param $sheet
     * @param bool|false $actualizar_datos_producto
     * @return array|bool|\Illuminate\Database\Eloquent\Collection
     */
    public function actualizarFichaConDetalles(array $sheet, $actualizar_datos_producto = false) {
        $calidad = strtoupper(trim($sheet['quality']));
        $this->calidad = in_array($calidad, ['INTERNO', 'FABRICANTE', 'ICECAT', 'NOEDITOR']) ? $calidad : null;
        $this->titulo = $sheet['title'];

        $icecat_category_id = $sheet['icecat_category_id'];

        // Guardar características
        $fichas_caracteristicas = [];
        foreach ($sheet['features'] as $caracteristica) {

            $category_feature =
                IcecatCategoryFeature::where('icecat_category_id', $icecat_category_id)
                    ->where('icecat_category_feature_group_id', $caracteristica['icecat_category_feature_group_id'])
                    ->where('icecat_feature_id', $caracteristica['icecat_feature_id'])
                    ->first(['id']);

            if (!empty($caracteristica['value']) && !empty($category_feature)) {

                if (empty($caracteristica_vieja = FichaCaracteristica::whereCategoryFeatureId($category_feature->id)->whereFichaId($this->id)->first())) {
                    // Característica nueva
                    $ficha_caracteristica = new FichaCaracteristica([
                        'category_feature_id' => $category_feature->id,
                        'valor'               => $caracteristica['value'],
                        'valor_presentacion'  => $caracteristica['presentation_value']
                    ]);
                    array_push($fichas_caracteristicas, $ficha_caracteristica);
                } else {
                    // Característica existente
                    $caracteristica_vieja->update([
                        'valor'              => $caracteristica['value'],
                        'valor_presentacion' => $caracteristica['presentation_value']
                    ]);
                }
            }
        }

        if ($this->save()) {
            if ($actualizar_datos_producto) {
                $nuevos_valores = [];
                $icecat_category = IcecatCategory::whereIcecatId($icecat_category_id)->first();
                if (!empty($icecat_category)) {
                    $nuevos_valores = array_merge($nuevos_valores, ['subfamilia_id' => $icecat_category->subfamilia_id]);
                }
                $this->producto->update(array_merge($nuevos_valores, [
                    'descripcion'       => substr($sheet['long_summary_description'], 0, 299),
                    'descripcion_corta' => substr($sheet['short_summary_description'], 0, 49)
                ]));
            }

            return $this->caracteristicas()->saveMany($fichas_caracteristicas);
        } else {
            return false;
        }
    }

    /**
     * Intenta obtener la ficha para un producto desde Icecat, guarda los datos encontrados en la base de datos
     * para poder construir las fichas.
     * @param bool $sobrescribir_datos_producto
     * @return bool
     */
    public function obtenerFichaDesdeIcecat($sobrescribir_datos_producto = false) {
        $icecat_feed = new IcecatFeed();
        $sheet = $icecat_feed->getProductSheet($this->producto);
        if (!empty($sheet)) {
            return $this->guardarFichaConDetalles($sheet, $sobrescribir_datos_producto);
        } else {
            $this->calidad = 'INTERNO';
            $this->titulo = substr($this->producto, 0, 49);
            $this->revisada = false;
            $this->save();

            return false;
        }
    }

    /**
     * Obtiene la ficha del producto desde Icecat y actualiza los valores que se generaron de una consulta anterior
     * @param bool $actualizar_datos_producto
     * @return bool
     */
    public function actualizarFichaDesdeIcecat($actualizar_datos_producto = false) {
        $icecat_feed = new IcecatFeed();
        $sheet = $icecat_feed->getProductSheet($this->producto);
        if (!empty($sheet)) {
            return $this->actualizarFichaConDetalles($sheet, $actualizar_datos_producto);
        } else {
            return false;
        }
    }

    /**
     * Este método recibe un array de arrays asociativos con atributos válidos para el modelo de FichaCaracteristica
     * y los asocia con la ficha
     * @param array $caracteristicas
     */
    public function agregarCaracteristicas(array $caracteristicas) {
        $caracteristicas = array_map(function ($caracteristica) {
            return new FichaCaracteristica($caracteristica);
        }, $caracteristicas);
        $this->caracteristicas()->saveMany($caracteristicas);
    }

    /**
     * Este método recibe un array de arrays asociativos con datos válidos para FichaCaracteristica,
     * y alguno coincide con una característica existente de la ficha, actualiza sus valores.
     * @param array $caracteristicas
     */
    public function actualizarCaracteristicas(array $caracteristicas) {
        foreach ($caracteristicas as $caracteristica) {
            if (!empty($caracteristica_asociada = FichaCaracteristica::find($caracteristica['id']))) {
                $caracteristica_asociada->update($caracteristica);
            }
        }
    }

    /**
     * Este método realiza una consulta para obtener de manera organizada los datos listos
     * para mostrar en la ficha técnica del producto asociado.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fichaCompleta(){
        return $this->caracteristicas()
            ->join('icecat_categories_features', 'fichas_caracteristicas.category_feature_id', '=', 'icecat_categories_features.id')
            ->join('icecat_categories', 'icecat_categories_features.icecat_category_id', '=','icecat_categories.icecat_id')
            ->join('icecat_features', 'icecat_categories_features.icecat_feature_id', '=', 'icecat_features.icecat_id')
            ->join('icecat_categories_feature_groups','icecat_categories_features.icecat_category_feature_group_id', '=','icecat_categories_feature_groups.icecat_id')
            ->join('icecat_feature_groups', 'icecat_categories_feature_groups.icecat_feature_group_id', '=', 'icecat_feature_groups.icecat_id')
            ->select(
                'icecat_feature_groups.name as feature_group',
                'icecat_features.name as feature',
                'icecat_features.description',
                'fichas_caracteristicas.valor',
                'fichas_caracteristicas.valor_presentacion'
            )
            ->orderBy('icecat_feature_groups.name')
            ->orderBy('icecat_features.name')
            ->get()->groupBy('feature_group');
    }


    /**
     * Obtiene el producto para el cual está definida esta ficha
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto() {
        return $this->belongsTo('App\Producto');
    }

    /**
     * Obtiene las características asociadas a esta ficha
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function caracteristicas() {
        return $this->hasMany('App\FichaCaracteristica');
    }

    /**
     * Obtiene las imágenes de galería relacionadas con esta ficha
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function galerias(){
        return $this->hasMany('App\Galeria');
    }

}
