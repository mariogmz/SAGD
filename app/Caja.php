<?php

namespace App;


class Caja extends LGGModel {

    protected $table = "cajas";
    public $timestamps = false;
    protected $fillable = ['nombre', 'mac_addr', 'token', 'iteracion', 'sucursal_id'];

    public static $rules = [
        'nombre'      => 'required|string|max:45',
        'mac_addr'    => 'required|string|max:45',
        'token'       => 'required|string|size:6',
        'iteracion'   => 'required|integer',
        'sucursal_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Caja::creating(function ($model) {
            return $model->isValid();
        });
        Caja::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene la sucursal a la cual está asignada la caja
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene los cortes asociados a esta caja
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cortes(){
        return $this->hasMany('App\Corte');
    }
}
