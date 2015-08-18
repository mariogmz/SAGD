<?php

namespace App;


/**
 * App\MetodoPagoRango
 *
 * @property integer $id
 * @property float $desde
 * @property float $hasta
 * @property float $valor
 * @property integer $metodo_pago_id
 * @property-read \App\MetodoPago $metodoPago
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPagoRango whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPagoRango whereDesde($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPagoRango whereHasta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPagoRango whereValor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPagoRango whereMetodoPagoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class MetodoPagoRango extends LGGModel {

    //
    protected $table = "metodos_pagos_rangos";
    public $timestamps = false;
    protected $fillable = ['hasta', 'desde', 'valor', 'metodo_pago_id'];

    public static $rules = [
        'desde'          => 'required|numeric|between:0.00,1.00',
        'hasta'          => 'required|numeric|between:0.00,1.00|greater_than:desde',
        'valor'          => 'required|numeric|between:0.00,1.00',
        'metodo_pago_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        MetodoPagoRango::creating(function ($model) {
            return $model->isValid() && self::revisarRango($model);
        });
        MetodoPagoRango::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update') && self::revisarRango($model);
        });
    }

    /**
     * Obtiene el método de pago asociado a este rango de método de pago
     * @return App\MetodoPago
     */
    public function metodoPago() {
        return $this->belongsTo('App\MetodoPago');
    }

    public static function revisarRango($model) {
        $rangos = self::where('id', '<>', is_null($model->id) ? 'null' : $model->id)
            ->where('metodo_pago_id', $model->metodo_pago_id)
            ->where('desde', '<>', $model->desde)
            ->where('hasta', '<>', $model->hasta)->get();
        $conjunto = [];
        foreach ($rangos as $rango) {
            $min = $rango->desde * 100;
            $max = $rango->hasta * 100;
            for ($i = $min; $i <= $max; $i ++) {
                array_push($conjunto, $i);
            }
        }
        $conjunto_modelo = [];
        for ($i = $model->desde * 100; $i <= $model->hasta * 100; $i ++) {
            array_push($conjunto_modelo, $i);
        }

        return !count(array_intersect($conjunto_modelo, $conjunto));
    }

}
