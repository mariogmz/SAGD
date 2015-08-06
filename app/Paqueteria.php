<?php

namespace App;

class Paqueteria extends LGGModel
{
    //
    protected $table = "paqueterias";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre', 'url', 'horario', 'condicion_entrega', 'seguro'];

    public static $rules = [
        'clave' => "required|max:6|unique:paqueterias",
        'nombre' => 'required|max:45',
        'url' => 'url|max:100',
        'horario' => 'max:60',
        'condicion_entrega' => 'max:100',
        'seguro' => 'required|numeric|min:0.0|max:1.0'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Paqueteria::creating(function($model){
            $model->clave = strtoupper($model->clave);
            return $model->isValid();
        });
        Paqueteria::updating(function($paqueteria){
            $paqueteria->clave = strtoupper($paqueteria->clave);
            $paqueteria->updateRules = self::$rules;
            $paqueteria->updateRules['clave'] .= ',clave,'.$paqueteria->id;
            return $paqueteria->isValid('update');
        });
    }

    /**
     * Obtiene los Rangos asociados con la Paqueteria
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function rangos()
    {
        return $this->hasMany('App\PaqueteriaRango', 'paqueteria_id');
    }
}
