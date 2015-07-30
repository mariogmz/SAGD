<?php

namespace App;


class RmaTiempo extends LGGModel {

    protected $table = "rmas_tiempos";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|string|max:45|unique:rmas_tiempos'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        RmaTiempo::creating(function ($model)
        {
            if (!$model->isValid())
            {
                return false;
            }

            return true;
        });
        RmaTiempo::updating(function($rmat){
            $rmat->updateRules = self::$rules;
            $rmat->updateRules['nombre'] .= ',nombre,'.$rmat->id;
            return $rmat->isValid('update');
        });
    }

    /**
     * Obtiene todos los rmas con el tiempo asociado
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmas(){
        return $this->hasMany('App\Rma');
    }
}
