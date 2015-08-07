<?php

namespace App;


class MetodoPagoRango extends LGGModel {

    //
    protected $table = "metodos_pagos_rangos";
    public $timestamps = false;
    protected $fillable = ['hasta', 'desde', 'valor', 'metodo_pago_id'];

    public static $rules = [
        'desde'          => 'required|numeric|between:0.00,1.00|unique:metodos_pagos_rangos',
        'hasta'          => 'required|numeric|between:0.00,1.00|greater_than:desde|unique:metodos_pagos_rangos',
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
            return $model->isValid() && self::revisarRango($model);
        });
        MetodoPagoRango::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['desde'] .= ',desde,' . $model->id;
            $model->updateRules['hasta'] .= ',hasta,' . $model->id;

            return $model->isValid('update') && self::revisarRango($model);
        });
    }

    /**
     * Obtiene el método de pago asociado a este rango de método de pago
     * @return App\MetodoPago
     */
    public function metodoPago() {
        return $this->belongsTo('App\MetodoPago');
    }

    public static function revisarRango($model) {
        $rangos = self::all(['desde', 'hasta']);
        foreach ($rangos as $rango) {
            if ($model->hasta >= $rango->hasta ||
                $model->hasta <= $rango->desde ||
                $model->desde >= $rango->hasta ||
                $model->desde <= $rango->desde
            )
                return false;
        }

        return true;
    }

}
