<?php

namespace App;


class TipoPartida extends LGGModel {

    protected $table = "tipos_partidas";
    public $timestamps = false;
    protected $fillable = [
        'clave', 'nombre', 'ticket', 'ticket_suma', 'pago'
    ];

    public static $rules = [
        'clave'       => 'required|string|max:25|unique:tipos_partidas',
        'nombre'      => 'required|string|max:50',
        'ticket'      => 'required|boolean',
        'ticket_suma' => 'required|boolean',
        'pago'        => 'required|boolean'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        TipoPartida::creating(function ($model) {
            return $model->isValid();
        });
        TipoPartida::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,' . $model->id;

            return $model->isValid('update');
        });
    }
}
