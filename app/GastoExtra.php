<?php

namespace App;


/**
 * App\GastoExtra
 *
 * @property integer $id
 * @property float $monto
 * @property string $concepto
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $caja_id
 * @property integer $corte_id
 * @property-read \App\Caja $caja
 * @property-read \App\Corte $corte
 * @method static \Illuminate\Database\Query\Builder|\App\GastoExtra whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GastoExtra whereMonto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GastoExtra whereConcepto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GastoExtra whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GastoExtra whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GastoExtra whereCajaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GastoExtra whereCorteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
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
        parent::boot();
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
