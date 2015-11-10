<?php

namespace App;


/**
 * App\SalidaDetalle
 *
 * @property integer $id
 * @property integer $cantidad
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $salida_id
 * @property integer $producto_id
 * @property integer $producto_movimiento_id
 * @property-read \App\Producto $producto
 * @property-read \App\ProductoMovimiento $productoMovimiento
 * @property-read \App\Salida $salida
 * @method static \Illuminate\Database\Query\Builder|\App\SalidaDetalle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SalidaDetalle whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SalidaDetalle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SalidaDetalle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SalidaDetalle whereSalidaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SalidaDetalle whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SalidaDetalle whereProductoMovimientoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SalidaDetalle whereDeletedAt($value)
 */
class SalidaDetalle extends LGGModel {

    //
    protected $table = "salidas_detalles";
    public $timestamps = true;
    protected $fillable = ['cantidad', 'producto_id', 'producto_movimiento_id',
        'salida_id'];

    public static $rules = [
        'cantidad'               => 'required|integer',
        'producto_id'            => 'required|integer',
        'producto_movimiento_id' => 'required|integer',
        'salida_id'              => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        SalidaDetalle::creating(function ($model) {
            return $model->isValid();
        });
        SalidaDetalle::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene el Producto asociado con la Salida Detalle
     * @return App\Producto::class
     */
    public function producto() {
        return $this->belongsTo('App\Producto', 'producto_id');
    }


    /**
     * Obtiene el ProductoMovimiento asociado con la Salida Detalle
     * @return App\ProductoMovimiento
     */
    public function productoMovimiento() {
        return $this->belongsTo('App\ProductoMovimiento', 'producto_movimiento_id');
    }


    /**
     * Obtiene la Salida asociada con la Salida Detalle
     * @return App\Salida
     */
    public function salida() {
        return $this->belongsTo('App\Salida', 'salida_id');
    }
}
