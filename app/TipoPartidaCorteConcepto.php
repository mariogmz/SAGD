<?php

namespace App;


class TipoPartidaCorteConcepto extends LGGModel {

    protected $table = "tipos_partidas_cortes_conceptos";
    public $timestamps = false;
    protected $fillable = ['tipo_partida_id', 'corte_concepto_id'];

    public static $rules = [
        'tipo_partida_id'   => 'required|integer',
        'corte_concepto_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        TipoPartidaCorteConcepto::creating(function ($model) {
            return $model->isValid();
        });
        TipoPartidaCorteConcepto::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el tipo de partida
     * @return App\TipoPartida
     */
    public function tipoPartida() {
        return $this->belongsTo('App\TipoPartida');
    }

    /**
     * Obtiene el concepto de corte
     * @return App\CorteConcepto
     */
    public function corteConcepto() {
        return $this->belongsTo('App\CorteConcepto');
    }
}
