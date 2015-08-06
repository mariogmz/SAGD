<?php

namespace App;

class Zona extends LGGModel
{
    //
    protected $table = "zonas";
    public $timestamps = false;
    protected $fillable = ['clave', 'km_maximos'];

    public static $rules = [
        'clave' => 'required|max:6|unique:zonas',
        'km_maximos' => 'required|numeric|min:0.0',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Zona::creating(function($model){
            $model->clave = strtoupper($model->clave);
            return $model->isValid();
        });
        Zona::updating(function($model){
            $model->clave = strtoupper($model->clave);
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,'.$model->id;
            return $model->isValid('update');
        });
    }
}
