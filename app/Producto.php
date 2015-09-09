<?php

namespace App;


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
 * @property-read \App\Dimension $dimension
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProductoMovimiento[] $productoMovimientos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProductoSucursal[] $productosSucursales
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sucursal[] $sucursales
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

    //
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
        'fecha_entrada'     => 'required|date',
        'numero_parte'      => 'required|unique:productos',
        'remate'            => 'required|boolean',
        'spiff'             => 'required|numeric',
        'subclave'          => 'required',
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
            $producto->updateRules['numero_parte'] .= ',numero_parte,' . $producto->id;
            $producto->updateRules['upc'] .= ',upc,' . $producto->id;

            return $producto->isValid('update');
        });
    }

    /**
     * Agrega una sucursal para un producto
     * @param App\Sucursal
     * @return void
     */
    public function addSucursal($sucursal) {
        $this->sucursales()->attach($sucursal->id, ['proveedor_id' => $sucursal->proveedor->id]);
    }

    /**
     * Agrega el proveedor y sucursales para un producto
     * @param App\Proveedor
     * @return void
     */
    public function addProveedor($proveedor) {
        $sucursales = $proveedor->sucursales;
        foreach ($sucursales as $sucursal) {
            $this->proveedores()->attach($proveedor->id, ['sucursal_id' => $sucursal->id]);
        }
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
     * Obtiene los productos_movimientos relacionados con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function productoMovimientos() {
        return $this->hasMany('App\ProductoMovimiento');
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
        return $this->belongsToMany('App\Proveedor', 'productos_sucursales',
            'producto_id', 'proveedor_id');
    }

    /**
     * Obtiene las existencias relacionadas con el Producto
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function existencias($sucursal_id = null) {
        if (is_null($sucursal_id)) {
            return $this->hasManyThrough('App\Existencia', 'App\ProductoSucursal',
                'producto_id', 'productos_sucursales_id');
        } else {
            $ps = $this->productosSucursales->where('sucursal_id', $sucursal_id)->last();

            return $ps->existencias;
        }
    }

    public function precios($proveedor_id = null) {
        if (is_null($proveedor_id)) {
            return $this->hasManyThrough('App\Precio', 'App\ProductoSucursal',
                'producto_id', 'producto_sucursal_id');
        } else {
            $ps = $this->productosSucursales->where('proveedor_id', $proveedor_id)->first();

            return $ps->precios;
        }
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

}