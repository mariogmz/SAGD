<?php

namespace App;

class Guia extends LGGModel
{
    //
    protected $table = "guias";
    public $timestamps = false;
    protected $fillable = ['nombre', 'volumen_maximo', 'ampara_hasta', 'paqueteria_id', 'estatus_activo_id'];

    public static $rules = [
        'nombre' => 'max:80',
        'volumen_maximo' => 'required|numeric|min:0.0',
        'ampara_hasta' => 'required|numeric|min:0.0',
        'paqueteria_id' => 'required|integer',
        'estatus_activo_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Guia::creating(function($model){
            return $model->isValid();
        });
        Guia::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene la Paqueteria asociada con la Guia
    * @return App\Paqueteria
    */
    public function paqueteria()
    {
        return $this->belongsTo('App\Paqueteria', 'paqueteria_id');
    }


    /**
    * Obtiene el Estaus Activo asociado con la Guia
    * @return App\EstatusActivo
    */
    public function estatus()
    {
        return $this->belongsTo('App\EstatusActivo', 'estatus_activo_id');
    }


    /**
    * Obtiene las Guias Zonas asociadas con la Guia
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function guiasZonas()
    {
        return $this->hasMany('App\GuiaZona', 'guia_id');
    }


    /**
    * Obtiene las Zonas a traves de Guias Zonas asociadas con la Guia
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function zonas()
    {
        return $this->belongsToMany('App\Zona', 'guias_zonas', 'guia_id', 'zona_id');
    }
}
