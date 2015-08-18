<?php

namespace App;


/**
 * App\CorteDetalle
 *
 * @property integer $id
 * @property float $monto
 * @property integer $corte_id
 * @property integer $corte_concepto_id
 * @property-read \App\Corte $corte
 * @property-read \App\CorteConcepto $corteConcepto
 * @method static \Illuminate\Database\Query\Builder|\App\CorteDetalle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CorteDetalle whereMonto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CorteDetalle whereCorteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CorteDetalle whereCorteConceptoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
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
