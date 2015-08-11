<?php

namespace App;


class EstadoVenta extends LGGModel {

    protected $table = "estados_ventas";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave'  => 'required|string|alpha|size:1|unique:estados_ventas',
        'nombre' => 'required|string|max:60'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        EstadoVenta::creating(function ($model) {
            return $model->isValid();
        });
        EstadoVenta::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,' . $model->id;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene las ventas con el estado relacionado
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventas() {
        return $this->hasMany('App\Venta');
    }

    /**
     * Obtiene los movimientos de venta asociados con el estado de venta
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventasMovimientos() {
        return $this->hasMany('App\VentaMovimiento');
    }

}

