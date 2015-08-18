<?php

namespace App;


/**
 * App\SoporteProducto
 *
 * @property integer $id
 * @property integer $cantidad
 * @property float $precio
 * @property integer $servicio_soporte_id
 * @property integer $producto_id
 * @property-read \App\ServicioSoporte $servicioSoporte
 * @property-read \App\Producto $producto
 * @method static \Illuminate\Database\Query\Builder|\App\SoporteProducto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SoporteProducto whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SoporteProducto wherePrecio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SoporteProducto whereServicioSoporteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SoporteProducto whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class SoporteProducto extends LGGModel {

    //
    protected $table = "soportes_productos";
    public $timestamps = false;
    protected $fillable = ['cantidad', 'precio', 'soporte_id', 'producto_id'];

    public static $rules = [
        'cantidad'            => 'required|integer',
        'precio'              => 'required|numeric',
        'servicio_soporte_id' => 'required|integer',
        'producto_id'         => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        SoporteProducto::creating(function ($model) {
            if (!$model->isValid()) {
                return false;
            }

            return true;
        });
        SoporteProducto::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid();
        });
    }

    /**
     * Obtiene el soporte asociado a este soporte de producto
     * @returns App\ServicioSoporte
     */
    public function servicioSoporte() {
        return $this->belongsTo('App\ServicioSoporte');
    }

    /**
     * Obtiene el producto asociado a este soporte de producto
     * @returns App\Producto
     */
    public function producto() {
        return $this->belongsTo('App\Producto');
    }
}
