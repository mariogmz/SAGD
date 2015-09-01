<?php

namespace App;


/**
 * App\PaqueteriaRango
 *
 * @property integer $id
 * @property float $desde
 * @property float $hasta
 * @property float $valor
 * @property boolean $distribuidor
 * @property integer $paqueteria_id
 * @property-read \App\Paqueteria $paqueteria
 * @method static \Illuminate\Database\Query\Builder|\App\PaqueteriaRango whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaqueteriaRango whereDesde($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaqueteriaRango whereHasta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaqueteriaRango whereValor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaqueteriaRango whereDistribuidor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaqueteriaRango wherePaqueteriaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class PaqueteriaRango extends LGGModel {

    //
    protected $table = "paqueterias_rangos";
    public $timestamps = false;
    protected $fillable = ['desde', 'hasta', 'valor', 'distribuidor', 'paqueteria_id'];

    public static $rules = [
        'desde'         => 'required|numeric|min:0.0|max:1.0|less_than:hasta',
        'hasta'         => 'required|numeric|min:0.0|max:1.0|greater_than:desde',
        'valor'         => 'required|numeric|min:0.0|max:1.0',
        'distribuidor'  => 'required|boolean',
        'paqueteria_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        PaqueteriaRango::creating(function ($model) {
            return $model->isValid();
        });
        PaqueteriaRango::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene la Paqueteria asociada con la Paqueteria Rango
     * @return App\Paqueteria
     */
    public function paqueteria() {
        return $this->belongsTo('App\Paqueteria', 'paqueteria_id');
    }
}
