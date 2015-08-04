<?php

namespace App;


class GastoExtra extends LGGModel {

    protected $table = "gastos_extras";
    public $timestamps = true;
    protected $fillable = ['monto', 'concepto', 'caja_id', 'corte_id'];

    public static $rules = [
        'monto'    => 'required|numeric',
        'concepto' => 'required|string|max:45',
        'caja_id'  => 'required|integer',
        'corte_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        GastoExtra::creating(function ($model) {
            return $model->isValid();
        });
        GastoExtra::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene la caja asociada al gasto extra
     * @return App\Caja
     */
    public function caja() {
        return $this->belongsTo('App\Caja');
    }

    /**
     * Obtiene el corte al que pertenece el gasto extra
     * @return App\Corte
     */
    public function corte() {
        return $this->belongsTo('App\Corte');
    }
}
