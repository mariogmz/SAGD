<?php

namespace App;


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
                $this->producto->update([
                    'descripcion' => substr($sheet['long_summary_description'],0,299),
                    'descripcion_corta' => substr($sheet['short_summary_description'],0,49)
                ]);
            }

            return $this->caracteristicas()->saveMany($fichas_caracteristicas);
        } else {
            return false;
        }
    }

    /**
     * Intenta obtener la ficha para un producto desde Icecat
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
            $this->titulo = '';
            $this->revisada = false;
            $this->save();

            return false;
        }
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

}
