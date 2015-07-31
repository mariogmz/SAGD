<?php

namespace App;


class MetodoPagoRango extends LGGModel {

    //
    protected $table = "metodos_pagos_rangos";
    public $timestamps = false;
    protected $fillable = ['hasta', 'desde', 'valor', 'metodo_pago_id'];

    public static $rules = [
        'desde'          => 'required|numeric|between:0.00,1.00',
        'hasta'          => 'required|numeric|between:0.00,1.00|greater_than:desde',
        'valor'          => 'required|numeric|between:0.00,1.00',
        'metodo_pago_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        MetodoPagoRango::creating(function ($model) {
            return $model->isValid();
        });
        MetodoPagoRango::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

}
