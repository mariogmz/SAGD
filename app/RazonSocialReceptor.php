<?php

namespace App;

class RazonSocialReceptor extends LGGModel
{
    //
    protected $table = "razones_sociales_receptores";
    public $timestamps = false;
    protected $fillable = ['rfc', 'regimen', 'domicilio_id', 'cliente_id'];

    public static $rules = [
        'rfc' => "min:13|max:13|regex:'[A-Z]{4}\d{6}[A-Z]\d{2}'",
        'regimen' => 'max:60',
        'domicilio_id' => 'required|integer',
        'cliente_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        RazonSocialReceptor::creating(function($model){
            return $model->isValid();
        });
        RazonSocialReceptor::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene el Domicilio asociado con la Razon Social
    * @return App\Domicilio
    */
    public function domicilio()
    {
        return $this->belongsTo('App\Domicilio', 'domicilio_id');
    }


    /**
    * Obtiene el Cliente asociado con la Razon Social
    * @return App\Cliente
    */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }
}
