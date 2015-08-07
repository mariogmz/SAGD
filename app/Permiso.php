<?php

namespace App;

class Permiso extends LGGModel
{
    //
    protected $table = "permisos";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave' => 'required|max:10|unique:permisos',
        'nombre' => 'required|max:45'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Permiso::creating(function($model){
            $model->clave = strtoupper($model->clave);
            return $model->isValid();
        });
        Permiso::updating(function($model){
            $model->clave = strtoupper($model->clave);
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,'.$model->id;
            return $model->isValid('update');
        });
    }
}
