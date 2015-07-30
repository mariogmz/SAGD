<?php

namespace App;


class SoporteProducto extends LGGModel {

    //
    protected $table = "soportes_productos";
    public $timestamps = false;
    protected $fillable = ['cantidad', 'precio', 'soporte_id', 'producto_id'];

    public static $rules = [];

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
    }

    /**
     * Obtiene el soporte asociado a este soporte de producto
     * @returns App\ServicioSoporte
     */
    public function servicioSoporte(){
        return $this->belongsTo('App\ServicioSoporte');
    }
}
