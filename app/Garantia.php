<?php

namespace App;


class Garantia extends LGGModel {

    protected $table = "garantias";
    public $timestamps = false;
    protected $fillable = ['serie', 'venta_detalle_id'];

    public static $rules = [
        'serie'            => 'required|string|max:45',
        'venta_detalle_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Garantia::creating(function ($model) {
            return $model->isValid();
        });
        Garantia::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el detalle de la venta asociado con esta garantia
     * @return App\VentaDetalle
     */
    public function ventaDetalle() {
        return $this->belongsTo('App\VentaDetalle');
    }

    /**
     * Obtiene los detalles de RMA que están asociados con esta garantía
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmasDetalles() {
        return $this->hasMany('App\RmaDetalle');
    }

    /**
     * Obtiene las reposiciones realizadas asociadas a esta garantía
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function reposiciones() {
        return $this->hasMany('App\Reposicion');
    }


}
