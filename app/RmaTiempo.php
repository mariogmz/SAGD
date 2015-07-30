<?php

namespace App;


class RmaTiempo extends LGGModel {

    protected $table = "rmas_tiempos";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|string|max:45|unique:rmas_tiempos'
    ];

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
    }

    /**
     * Obtiene todos los rmas con el tiempo asociado
     * @return array
     */
    public function rmas(){
        return $this->hasMany('App\Rma');
    }
}
