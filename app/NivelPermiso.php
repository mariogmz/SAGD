<?php

namespace App;

class NivelPermiso extends LGGModel
{
    //
    protected $table = "niveles_permisos";
    public $timestamps = false;
    protected $fillable = ['nombre', 'nivel'];

    public static $rules = [
        'nombre' => 'required|max:45',
        'nivel' => 'required|integer|min:0',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        NivelPermiso::creating(function($model){
            return $model->isValid();
        });
        NivelPermiso::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }
}
