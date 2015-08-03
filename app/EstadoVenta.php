<?php

namespace App;


class EstadoVenta extends LGGModel {

    //
    protected $table = "estados_ventas";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave'  => 'required|string|size:1|unique:estados_ventas',
        'nombre' => 'required|string|max:60'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        EstadoVenta::creating(function ($model) {
            return $model->isValid();
        });
        EstadoVenta::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,' . $model->id;

            return $model->isValid('update');
        });
    }
}
