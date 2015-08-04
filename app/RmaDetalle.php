<?php

namespace App;


class RmaDetalle extends LGGModel {

    //
    protected $table = "rmas_detalles";
    public $timestamps = false;
    protected $fillable = ['descripcion_falla', 'rma_id', 'garantia_id', 'producto_movimiento_id'];

    public static $rules = [
        'descripcion_falla'      => 'required|string|max:80',
        'rma_id'                 => 'required|integer',
        'garantia_id'            => 'integer',
        'producto_movimiento_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        RmaDetalle::creating(function ($model) {
            if (!$model->isValid()) {
                return false;
            }

            return true;
        });
        RmaDetalle::updating(function ($rma_detalle) {
            $rma_detalle->updateRules = self::$rules;
            return $rma_detalle->isValid();
        });
    }

    /**
     * Obtiene el rma al que pertenece este detalle
     * @return App\Rma
     */
    public function rma() {
        return $this->belongsTo('App\Rma');
    }

    /**
     * Obtiene la garantia de venta asociada a este detalle
     * @return App\Garantia
     */
    public function garantia() {
        return $this->belongsTo('App\Garantia');
    }

    /**
     * Obtiene el movimiento de producto asociado a este detalle
     * @return App\ProductoMovimiento
     */
    public function productoMovimiento() {
        return $this->belongsTo('App\ProductoMovimiento');
    }

}
