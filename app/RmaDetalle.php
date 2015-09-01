<?php

namespace App;


/**
 * App\RmaDetalle
 *
 * @property integer $id
 * @property string $descripcion_falla
 * @property integer $rma_id
 * @property integer $garantia_id
 * @property integer $producto_movimiento_id
 * @property-read \App\Rma $rma
 * @property-read \App\Garantia $garantia
 * @property-read \App\ProductoMovimiento $productoMovimiento
 * @method static \Illuminate\Database\Query\Builder|\App\RmaDetalle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RmaDetalle whereDescripcionFalla($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RmaDetalle whereRmaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RmaDetalle whereGarantiaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RmaDetalle whereProductoMovimientoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class RmaDetalle extends LGGModel {

    protected $table = "rmas_detalles";
    public $timestamps = false;
    protected $fillable = ['descripcion_falla', 'rma_id', 'garantia_id', 'producto_movimiento_id'];

    public static $rules = [
        'descripcion_falla'      => 'required|string|max:80',
        'rma_id'                 => 'required|integer',
        'garantia_id'            => 'required|integer',
        'producto_movimiento_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        RmaDetalle::creating(function ($model) {
            return $model->isValid();
        });
        RmaDetalle::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid();
        });
    }

    /**
     * Obtiene el RMA al que pertenece este detalle
     * @return App\Rma
     */
    public function rma() {
        return $this->belongsTo('App\Rma');
    }

    /**
     * Obtiene la garantia asociada al detalle de rma
     * @return App\Garantia
     */
    public function garantia() {
        return $this->belongsTo('App\Garantia');
    }

    /**
     * Obtiene el movimiento de producto asociado al detalle del rma
     * @return App\ProductoMovimiento
     */
    public function productoMovimiento() {
        return $this->belongsTo('App\ProductoMovimiento');
    }

}
