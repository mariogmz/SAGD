<?php

namespace App;


class Anticipo extends LGGModel {

    protected $table = "anticipos";
    public $timestamps = false;
    protected $fillable = ['venta_id', 'venta_entrega_id', 'concepto', 'monto', 'cobrado'];

    public static $rules = [
        'venta_id'         => 'required|integer',
        'venta_entrega_id' => 'integer',
        'concepto'         => 'required|string|max:50',
        'monto'            => 'required|numeric',
        'cobrado'          => 'required|boolean'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Anticipo::creating(function ($model) {
            return $model->isValid();
        });
        Anticipo::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene la venta asociada a este anticipo
     * @return App\Venta
     */
    public function venta() {
        return $this->belongsTo('App\Venta');
    }

    /**
     * Obtiene la venta de entrega asociada a este anticipo
     * @return App\Venta
     */
    public function ventaEntrega() {
        return $this->belongsTo('App\Venta');
    }
}
