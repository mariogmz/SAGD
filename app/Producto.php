<?php

namespace App;


use DB;
use Illuminate\Support\MessageBag;
use App\Events\ProductoActualizado;


/**
 * App\Producto
 *
 * @property integer $id
 * @property boolean $activo
 * @property string $clave
 * @property string $descripcion
 * @property string $descripcion_corta
 * @property string $fecha_entrada
 * @property string $numero_parte
 * @property boolean $remate
 * @property float $spiff
 * @property string $subclave
 * @property string $upc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $tipo_garantia_id
 * @property integer $marca_id
 * @property integer $margen_id
 * @property integer $unidad_id
 * @property integer $subfamilia_id
 * @property-read \App\TipoGarantia $tipoGarantia
 * @property-read \App\Marca $marca
 * @property-read \App\Margen $margen
 * @property-read \App\Unidad $unidad
 * @property-read \App\Subfamilia $subfamilia
 * @property-read Dimension $dimension
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProductoMovimiento[] $productoMovimientos
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductoSucursal[] $productosSucursales
 * @property-read \Illuminate\Database\Eloquent\Collection|Sucursal[] $sucursales
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Proveedor[] $proveedores
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EntradaDetalle[] $entradasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SalidaDetalle[] $salidasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TransferenciaDetalle[] $transferenciasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ApartadoDetalle[] $apartadosDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reposicion[] $reposiciones
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereActivo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereDescripcionCorta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereFechaEntrada($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereNumeroParte($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereRemate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereSpiff($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereSubclave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereUpc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereTipoGarantiaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereMarcaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereMargenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereUnidadId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Producto whereSubfamiliaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Producto extends LGGModel {

    protected $table = "productos";
    public $timestamps = true;
    protected $fillable = ['activo', 'clave', 'descripcion', 'descripcion_corta',
        'fecha_entrada', 'numero_parte', 'remate', 'spiff', 'subclave', 'upc',
        'tipo_garantia_id', 'marca_id', 'margen_id', 'unidad_id', 'subfamilia_id'];

    public static $rules = [
        'activo'            => 'required|boolean',
        'clave'             => 'required|max:60|unique:productos',
        'descripcion'       => 'required|max:300',
        'descripcion_corta' => 'max:50',
        'fecha_entrada'     => 'date',
        'numero_parte'      => ['required','max:30','regex:`^([\w-\./#]+)\s?([\w-\./#]+)$`','unique:productos'],
        'remate'            => 'required|boolean',
        'spiff'             => 'required|numeric|min:0.0',
        'subclave'          => 'required|string|max:45',
        'upc'               => 'required|string|max:20|unique:productos',
        'tipo_garantia_id'  => 'required|integer',
        'marca_id'          => 'required|integer',
        'margen_id'         => 'integer',
        'unidad_id'         => 'required|integer',
        'subfamilia_id'     => 'required|integer',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Producto::creating(function ($producto) {
            $producto->subclave || $producto->subclave = $producto->numero_parte;
            if (!$producto->isValid()) {
                return false;
            }

            return true;
        });
        Producto::updating(function ($producto) {
            $producto->updateRules = self::$rules;
            $producto->updateRules['clave'] .= ',clave,' . $producto->id;
            $producto->updateRules['numero_parte'] = ['required','max:30','regex:`^([\w-\.#/]+)\s?([\w-\.#/]+)$`','unique:productos,numero_parte,' . $producto->id];
            $producto->updateRules['upc'] .= ',upc,' . $producto->id;

            return $producto->isValid('update');
        });
        Producto::updated(function ($producto) {
            event(new ProductoActualizado($producto));
        });
    }

    /**
     * Agrega una sucursal para un producto
     * @param App\Sucursal
     * @return void
     */
    public function addSucursal($sucursal) {
        $this->sucursales()->attach($sucursal->id);
    }

    /**
     * Gets the Tipo Garantia associated with Producto
     * @return App\TipoGarantia
     */
    public function tipoGarantia() {
        return $this->belongsTo('App\TipoGarantia', 'tipo_garantia_id');
    }

    /**
     * Gets the Marca associated with Producto
     * @return App\Marca
     */
    public function marca() {
        return $this->belongsTo('App\Marca', 'marca_id');
    }

    /**
     * Gets the Marge associated with Producto
     * @return App\Margen
     */
    public function margen() {
        return $this->belongsTo('App\Margen', 'margen_id');
    }

    /**
     * Get the Unidad associated with Producto
     * @return App\Unidad
     */
    public function unidad() {
        return $this->belongsTo('App\Unidad');
    }

    /**
     * Get the Subfamilia associated with Producto
     * @return App\Subfamilia
     */
    public function subfamilia() {
        return $this->belongsTo('App\Subfamilia');
    }

    /**
     * Obtiene la Dimension de Producto
     * @return App\Dimension
     */
    public function dimension() {
        return $this->hasOne('App\Dimension');
    }

    /**
     * Obtiene los productos_movimientos de todas las sucursales relacionados con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function movimientos(Sucursal $sucursal = null) {
        if (is_null($sucursal)) {
            return $this->hasManyThrough('App\ProductoMovimiento', 'App\ProductoSucursal',
                'producto_id', 'producto_sucursal_id');
        } else {
            return $this->productosSucursales()->where('sucursal_id', $sucursal->id)->first()->movimientos;
        }
    }

    /**
     * Obtiene los productos_sucursales relacionados con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function productosSucursales() {
        return $this->hasMany('App\ProductoSucursal');
    }

    /**
     * Obtiene las sucursales relacionadas con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function sucursales() {
        return $this->belongsToMany('App\Sucursal', 'productos_sucursales',
            'producto_id', 'sucursal_id');
    }

    /**
     * Obtiene los proveedores relacionados con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function proveedores() {
        return $this->sucursales()->with('proveedor')->get()->pluck('proveedor')->unique();
    }

    /**
     * Obtiene las existencias relacionadas con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function existencias(Sucursal $sucursal = null) {
        if (is_null($sucursal)) {
            return $this->hasManyThrough('App\Existencia', 'App\ProductoSucursal',
                'producto_id', 'productos_sucursales_id');
        } else {
            return $this->productosSucursales->where('sucursal_id', $sucursal->id)->first()->existencia;
        }
    }

    public function precios() {
        return $this->hasManyThrough('App\Precio', 'App\ProductoSucursal',
            'producto_id', 'producto_sucursal_id');
    }


    /**
     * Obtiene las Entradas Detalles asociadas con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function entradasDetalles() {
        return $this->hasMany('App\EntradaDetalle', 'producto_id');
    }


    /**
     * Obtiene las Salidas Detalles asociadas con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function salidasDetalles() {
        return $this->hasMany('App\SalidaDetalle', 'producto_id');
    }


    /**
     * Obtiene las Transferencias Detalles asociadas con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function transferenciasDetalles() {
        return $this->hasMany('App\TransferenciaDetalle', 'producto_id');
    }


    /**
     * Obtiene los Apartados Detalles asociados con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function apartadosDetalles() {
        return $this->hasMany('App\ApartadoDetalle', 'producto_id');
    }

    /**
     * Obtiene las reposiciones del producto
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function reposiciones() {
        return $this->hasMany('App\Reposicion');
    }

    /**
     * Obtienes los precios agrupados por proveedor
     * @return \lluminate\Database\Eloquent\Collection
     */
    public function preciosProveedor() {
        return $this->productosSucursales()
            ->join('precios', 'precios.producto_sucursal_id', '=', 'productos_sucursales.id')
            ->join('sucursales', 'productos_sucursales.sucursal_id', '=', 'sucursales.id')
            ->join('proveedores', 'sucursales.proveedor_id', '=', 'proveedores.id')
            ->select('proveedores.id AS proveedor_id', 'proveedores.clave', 'proveedores.externo', 'precios.costo', 'precios.precio_1',
                'precios.precio_2', 'precios.precio_3', 'precios.precio_4', 'precios.precio_5', 'precios.precio_6',
                'precios.precio_7', 'precios.precio_8', 'precios.precio_9', 'precios.precio_10','precios.descuento',DB::raw('sum(precios.revisado)>0 AS revisado'))
            ->groupBy('proveedores.id')
            ->get();
    }


    /**
     * Hace las operaciones correspondientes para guardar los datos del producto, inicializar sus existencias,
     * guardar sus precios por sucursal considerando que son iguales por proveedor, así como también guarda
     * los datos asociados en sus dimensiones.
     * @param array $parameters
     * @return bool
     */
    public function guardarNuevo($parameters) {
        $dimension = new Dimension($parameters['dimension']);
        $precio = new Precio($parameters['precio']);
        $dimension->producto_id = 0;
        $precio->producto_sucursal_id = 0;

        if ($this->isValid() && $dimension->isValid() && $precio->isValid()) {
            $this->save();
            $this->attachDimension($dimension);
            $this->attachSucursales();
            $this->guardarPrecios($precio);
            $this->inicializarExistencias();

            return true;
        } else {
            $this->errors || $this->errors = new MessageBag();
            if ($dimension->errors) {
                $this->errors->merge($dimension->errors);
            }
            if ($precio->errors) {
                $this->errors->merge($precio->errors);
            }
            return false;
        }
    }

    /**
     * Función que hace las operaciones necesarias para la actualización de datos del producto
     * @param array $parameters
     * @return bool
     */
    public function actualizar($parameters) {
        DB::beginTransaction();
        if ($this->update($parameters)
            && $this->dimension->update($parameters['dimension'])
            && (empty($precios_errores = $this->actualizarPreciosPorProveedor($parameters)))
        ) {
            DB::commit();

            return true;
        } else {
            $this->errors || $this->errors = new MessageBag();
            if ($this->dimension->errors) {
                $this->errors->merge($this->dimension->errors);
            }
            if ($precios_errores) {
                $this->errors->merge(['Precios' => $precios_errores]);
            }
            DB::rollback();

            return false;
        }
    }

    /**
     * @param Precio $precio_interno
     */
    private function guardarPrecios($precio_interno) {
        $precio_externo = $precio_interno->calcularPrecios($precio_interno->precio_1, $precio_interno->costo, true);
        $precio_externo = new Precio($precio_externo['precios']);
        foreach ($this->productosSucursales as $producto_sucursal) {
            if ($producto_sucursal->sucursal->proveedor->externo) {
                $producto_sucursal->precio()->save(clone $precio_externo);
            } else {
                $producto_sucursal->precio()->save(clone $precio_interno);
            }
        }
    }

    private function actualizarPreciosPorProveedor($parameters) {
        $precios_proveedor = $parameters['precios'];
        $errors = [];
        foreach ($precios_proveedor as $precio_proveedor) {
            $sucursales_id = Sucursal::whereProveedorId($precio_proveedor['proveedor_id'])->get()->pluck('id');
            $productos_sucursales = ProductoSucursal::with('precio')->whereIn('sucursal_id', $sucursales_id)->whereProductoId($parameters['id'])->get();

            foreach ($productos_sucursales as $producto_sucursal) {
                if (!$producto_sucursal->precio->update($precio_proveedor)) {
                    foreach ($producto_sucursal->precio->errors->toArray() as $err) {
                        if (!in_array($err, $errors)) {
                            array_push($errors, $err);
                        }
                    }
                }
            }
        }

        return $errors;
    }

    private function attachDimension($dimension) {
        $this->dimension()->save($dimension);
    }

    private function attachSucursales() {
        $sucursales = Sucursal::all();
        foreach ($sucursales as $sucursal) {
            $this->addSucursal($sucursal);
        }
    }

    private function inicializarExistencias() {
        $this->productosSucursales->each(function ($productoSucursal) {
            $productoSucursal->existencia()->save(new \App\Existencia);
        });
    }

}
