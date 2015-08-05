<?php

namespace App;


class CorteDetalle extends LGGModel {

    protected $table = "cortes_detalles";
    public $timestamps = false;
    protected $fillable = ['monto', 'corte_id', 'corte_concepto_id'];

    public static $rules = [
        'monto'             => 'required|numeric',
        'corte_id'          => 'required|integer',
        'corte_concepto_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        CorteDetalle::creating(function ($model) {
            return $model->isValid();
        });
        CorteDetalle::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el corte al que pertenece este detalle
     * @return App\Corte
     */
    public function corte() {
        return $this->belongsTo('App\Corte');
    }

    /**
     * Obtiene el concepto del corte al que pertenece este detalle
     * @return App\CorteConcepto
     */
    public function corteConcepto() {
        return $this->belongsTo('App\CorteConcepto');
    }

}
