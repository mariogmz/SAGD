<?php

namespace App;

class EstadoSalida extends LGGModel
{
    //
    protected $table = "estados_salidas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:45|unique:estados_salidas',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        EstadoSalida::creating(function($es){
            return $es->isValid();
        });
        EstadoSalida::updating(function($es){
            $es->updateRules = self::$rules;
            $es->updateRules['nombre'] .= ',nombre,'.$es->id;
            return $es->isValid('update');
        });
    }
}
