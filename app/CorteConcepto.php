<?php

namespace App;


class CorteConcepto extends LGGModel {

    protected $table = "cortes_conceptos";
    public $timestamps = false;
    protected $fillable = ['nombre', 'tipo_corte_concepto_id'];

    public static $rules = [
        'nombre'                 => 'required|string|max:45',
        'tipo_corte_concepto_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        CorteConcepto::creating(function ($model) {
            return $model->isValid();
        });
        CorteConcepto::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el tipo de concepto de corte para este concepto
     * @return App\TipoCorteConcepto
     */
    public function tipoCorteConcepto() {
        return $this->belongsTo('App\TipoCorteConcepto');
    }


}
