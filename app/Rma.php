<?php

namespace App;


class Rma extends LGGModel {

    protected $table = "rmas";
    public $timestamps = true;
    protected $fillable = ['estado_rma_id', 'cliente_id', 'empleado_id', 'rma_tiempo_id', 'sucursal_id', 'nota_credito_id'];

    public static $rules = [
        'estado_rma_id'   => 'required|integer',
        'cliente_id'      => 'required|integer',
        'empleado_id'     => 'required|integer',
        'rma_tiempo_id'   => 'required|integer',
        'sucursal_id'     => 'required|integer',
        'nota_credito_id' => 'integer'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        Rma::creating(function ($model)
        {
            if (!$model->isValid())
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene el cliente al que se le está aplicando el RMA
     * @return App\Cliente
     */
    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtiene el empleado que está aplicando el RMA
     * @return App\Empleado
     */
    public function empleado(){
        return $this->belongsTo('App\Empleado');
    }

    /**
     * Obtiene el estado del rma asociado
     * @return App\EstadoRma
     */
    public function estadoRma(){
        return $this->belongsTo('App\EstadoRma');
    }

    /**
     * Obtiene el estado del rma asociado
     * @return App\RmaTiempo
     */
    public function rmaTiempo(){
        return $this->belongsTo('App\RmaTiempo');
    }

    /**
     * Obtiene el estado del rma asociado
     * @return App\Sucursal
     */
    public function sucursal(){
        return $this->belongsTo('App\Sucursal');
    }
}
