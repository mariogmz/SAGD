<?php

namespace App;

class PaqueteriaCobertura extends LGGModel
{
    //
    protected $table = "paqueterias_coberturas";
    public $timestamps = false;
    protected $fillable = ['ocurre', 'paqueteria_id', 'codigo_postal_id'];

    public static $rules = [
        'ocurre' => 'required|numeric|min:0.0',
        'paqueteria_id' => 'required|integer',
        'codigo_postal_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        PaqueteriaCobertura::creating(function($model){
            return $model->isValid();
        });
        PaqueteriaCobertura::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene la Paqueteria asociada con la Cobertura
    * @return App\Paqueteria
    */
    public function paqueteria()
    {
        return $this->belongsTo('App\Paqueteria', 'paqueteria_id');
    }


    /**
    * Obtiene el Codigo Postal asociado con la Cobertura
    * @return App\CodigoPostal
    */
    public function codigoPostal()
    {
        return $this->belongsTo('App\CodigoPostal', 'codigo_postal_id');
    }
}
