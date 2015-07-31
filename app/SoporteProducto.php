<?php

namespace App;


class SoporteProducto extends LGGModel {

    //
    protected $table = "soportes_productos";
    public $timestamps = false;
    protected $fillable = ['cantidad', 'precio', 'soporte_id', 'producto_id'];

    public static $rules = [
        'cantidad'    => 'required|integer',
        'precio'      => 'required|numeric',
        'soporte_id'  => 'required|integer',
        'producto_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        SoporteProducto::creating(function ($model) {
            if (!$model->isValid()) {
                return false;
            }

            return true;
        });
        SoporteProducto::updating(function ($model)
        {
            $model->updateRules = self::$rules;
            return $model->isValid();
        });
    }

    /**
     * Obtiene el soporte asociado a este soporte de producto
     * @returns App\ServicioSoporte
     */
    public function servicioSoporte() {
        return $this->belongsTo('App\ServicioSoporte');
    }

    /**
     * Obtiene el producto asociado a este soporte de producto
     * @returns App\Producto
     */
    public function producto() {
        return $this->belongsTo('App\Producto');
    }
}
