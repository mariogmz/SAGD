<?php

namespace App;


class MetodoPago extends LGGModel {

    protected $table = "metodos_pagos";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre', 'comision', 'monto_minimo', 'informacion_adicional', 'estatus_activo_id'];

    public static $rules = [
        'clave'                 => 'required|string|max:10|unique:metodos_pagos',
        'nombre'                => 'string|max:45',
        'comision'              => 'required|numeric',
        'monto_minimo'          => 'required|numeric',
        'informacion_adicional' => 'string|max:100',
        'estatus_activo_id'     => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        MetodoPago::creating(function ($model) {
            return $model->isValid();
        });
        MetodoPago::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,'.$model->id;
            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el estatus asociado a la forma de pago
     * @return App\EstatusActivo
     */
    public function estatusActivo() {
        return $this->belongsTo('App\EstatusActivo', 'estatus_activo_id');
    }
}
