<?php

namespace App;


/**
 * App\TipoPartidaCorteConcepto
 *
 * @property integer $id
 * @property integer $tipo_partida_id
 * @property integer $corte_concepto_id
 * @property-read \App\TipoPartida $tipoPartida
 * @property-read \App\CorteConcepto $corteConcepto
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartidaCorteConcepto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartidaCorteConcepto whereTipoPartidaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoPartidaCorteConcepto whereCorteConceptoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
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
        parent::boot();
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
