<?php

namespace App;


class EstadoRma extends LGGModel {

    protected $table = "estados_rmas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|string|max:80|unique:estados_rmas'
    ];

    public $updateRules = [];

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
        EstadoRma::updating(function($estado_rma){
            $estado_rma->updateRules = self::$rules;
            $estado_rma->updateRules['nombre'] .= ',nombre,'.$estado_rma->id;
            return $estado_rma->isValid('update');
        });
    }

    /**
     * Obtiene todos los rmas que tienen asociado el estado_rma
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmas(){
        return $this->hasMany('App\Rma');
    }
}
