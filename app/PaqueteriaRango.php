<?php

namespace App;

class PaqueteriaRango extends LGGModel
{
    //
    protected $table = "paqueterias_rangos";
    public $timestamps = false;
    protected $fillable = ['desde', 'hasta', 'valor', 'distribuidor', 'paqueteria_id'];

    public static $rules = [
        'desde' => 'required|numeric|min:0.0|max:1.0|less_than:hasta',
        'hasta' => 'required|numeric|min:0.0|max:1.0|greater_than:desde',
        'valor' => 'required|numeric|min:0.0|max:1.0',
        'distribuidor' => 'required|boolean',
        'paqueteria_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        PaqueteriaRango::creating(function($model){
            return $model->isValid();
        });
        PaqueteriaRango::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene la Paqueteria asociada con la Paqueteria Rango
    * @return App\Paqueteria
    */
    public function paqueteria()
    {
        return $this->belongsTo('App\Paqueteria', 'paqueteria_id');
    }
}
