<?php

namespace App;

class EstadoEntrada extends LGGModel
{
    //
    protected $table = "estados_entradas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:45|unique:estados_entradas',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        EstadoEntrada::creating(function($ee){
            return $ee->isValid();
        });
        EstadoEntrada::updating(function($ee){
            $ee->updateRules = self::$rules;
            $ee->updateRules['nombre'] .= ',nombre,'.$ee->id;
            return $ee->isValid('update');
        });
    }
}
