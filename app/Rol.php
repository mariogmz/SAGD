<?php

namespace App;

class Rol extends LGGModel
{
    //
    protected $table = "roles";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave' => 'required|max:6',
        'nombre' => 'required|max:45'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Rol::creating(function($rol){
            $rol->clave = strtoupper($rol->clave);
            if ( !$rol->isValid() ){
                return false;
            }
            return true;
        });
        Rol::updating(function($rol){
            $rol->clave = strtoupper($rol->clave);
            $rol->updateRules = self::$rules;
            return $rol->isValid('update');
        });
    }
}
