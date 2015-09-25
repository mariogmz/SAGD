<?php

namespace App;


/**
 * App\ApartadoDetalle
 *
 * @property integer $id
 * @property integer $cantidad
 * @property integer $existencia_antes
 * @property integer $existencia_despues
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $apartado_id
 * @property integer $producto_id
 * @property integer $producto_movimiento_id
 * @property-read \App\Apartado $apartado
 * @property-read \App\Producto $producto
 * @property-read \App\ProductoMovimiento $productoMovimiento
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereExistenciaAntes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereExistenciaDespues($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereApartadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApartadoDetalle whereProductoMovimientoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class ApartadoDetalle extends LGGModel {

    //
    protected $table = "apartados_detalles";
    public $timestamps = true;
    protected $fillable = ['cantidad', 'existencia_antes', 'existencia_despues',
        'apartado_id', 'producto_id', 'producto_movimiento_id'];

    public static $rules = [
        'cantidad'               => 'required|integer|min:0',
        'existencia_antes'       => 'required|integer|min:0',
        'existencia_despues'     => 'required|integer|min:0',
        'apartado_id'            => 'required|integer',
        'producto_id'            => 'required|integer',
        'producto_movimiento_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        ApartadoDetalle::creating(function ($model) {
            return $model->isValid();
        });
        ApartadoDetalle::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene el Apartado asociado con el Detalle
     * @return App\Apartado
     */
    public function apartado() {
        return $this->belongsTo('App\Apartado', 'apartado_id');
    }


    /**
     * Obtiene el Producto asociado con el Detalle
     * @return App\Producto
     */
    public function producto() {
        return $this->belongsTo('App\Producto', 'producto_id');
    }


    /**
     * Obtiene el Producto Movimiento asociado con el Detalle
     * @return App\ProductoMovimiento
     */
    public function productoMovimiento() {
        return $this->belongsTo('App\ProductoMovimiento', 'producto_movimiento_id');
    }
}
