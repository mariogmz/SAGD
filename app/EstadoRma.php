<?php

namespace App;


class EstadoRma extends LGGModel {

    protected $table = "estados_rmas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|string|max:45|unique:estados_rmas'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        EstadoRma::creating(function ($model)
        {
            if (!$model->isValid())
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene todos los rmas que tienen asociado el estado_rma
     * @return array
     */
    public function rmas(){
        return $this->hasMany('App\Rma');
    }
}
