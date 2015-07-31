<?php

namespace App;


class SucursalEnvio extends LGGModel {

    protected $table = 'sucursales_envios';
    public $timestamps = true;

    protected $fillable = ['sucursal_origen_id', 'sucursal_destino_id', 'genera_costo', 'dias_max_envio'];
    public static $rules = [
        'sucursal_origen_id'  => 'required|integer',
        'sucursal_destino_id' => 'required|integer',
        'genera_costo'        => 'required|boolean',
        'dias_max_envio'      => 'required|integer|between:0,99'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        SucursalEnvio::creating(function ($sucursal_envio) {
            if (!$sucursal_envio->isValid()) {
                print_r($sucursal_envio->errors);
                return false;
            }

            return true;
        });
        SucursalEnvio::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid();
        });
    }

    /**
     * Obtiene la sucursal de origen a la cual está asociada el envío
     * @return App\Sucursal
     */
    public function sucursalOrigen() {
        return $this->belongsTo('App\Sucursal', 'sucursal_origen_id');
    }

    /**
     * Obtiene la sucursal destino a la cual está asociada el envío
     * @return App\Sucursal
     */
    public function sucursalDestino() {
        return $this->belongsTo('App\Sucursal', 'sucursal_destino_id');
    }
}
