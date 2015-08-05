<?php

namespace App;

class RazonSocialEmisor extends LGGModel
{
    //
    protected $table = "razones_sociales_emisores";
    public $timestamps = false;
    protected $fillable = ['sucursal_id', 'domicilio_id', 'rfc', 'regimen', 'serie', 'ultimo_folio',
        'numero_certificado', 'numero_certificado_sat'];

    public static $rules = [
        'rfc' => "required|min:13|max:13|regex:'[A-Z]{4}\d{6}[A-Z]\d{2}'",
        'regimen' => 'required|max:60',
        'serie' => 'required|max:3',
        'ultimo_folio' => 'required|integer',
        'numero_certificado' => 'required|integer',
        'numero_certificado_sat' => 'required|integer'

    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        RazonSocialEmisor::creating(function($model){
            return $model->isValid();
        });
        RazonSocialEmisor::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene la Sucursal asociada con la Razon Social Emisora
    * @return App\Sucursal
    */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
    * Obtiene el Domicilio asociado con la Razon Social Emisora
    * @return App\Domicilio
    */
    public function domicilio()
    {
        return $this->belongsTo('App\Domicilio', 'domicilio_id');
    }


    /**
    * Obtiene las Entradas asociadas con la Razon Social Emisora
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function entradas()
    {
        return $this->hasMany('App\Entrada', 'razon_social_id');
    }


    /**
    * Obtiene las Facturas asociadas con la Razon Social Emisora
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function facturas()
    {
        return $this->hasMany('App\Factura', 'razon_social_emisor_id');
    }
}
