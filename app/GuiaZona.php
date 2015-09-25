<?php

namespace App;


/**
 * App\GuiaZona
 *
 * @property integer $id
 * @property float $costo
 * @property float $costo_sobrepeso
 * @property integer $guia_id
 * @property integer $zona_id
 * @property-read \App\Guia $guia
 * @property-read \App\Zona $zona
 * @method static \Illuminate\Database\Query\Builder|\App\GuiaZona whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GuiaZona whereCosto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GuiaZona whereCostoSobrepeso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GuiaZona whereGuiaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GuiaZona whereZonaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class GuiaZona extends LGGModel {

    //
    protected $table = "guias_zonas";
    public $timestamps = false;
    protected $fillable = ['costo', 'costo_sobrepeso', 'guia_id', 'zona_id'];

    public static $rules = [
        'costo'           => 'required|numeric|min:0.0',
        'costo_sobrepeso' => 'required|numeric|min:0.0',
        'guia_id'         => 'required|integer',
        'zona_id'         => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        GuiaZona::creating(function ($model) {
            return $model->isValid();
        });
        GuiaZona::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene la Guia asociada con la Guia Zona
     * @return App\Guia
     */
    public function guia() {
        return $this->belongsTo('App\Guia', 'guia_id');
    }


    /**
     * Obtiene la Zona asociada con la Guia Zona
     * @return App\Zona
     */
    public function zona() {
        return $this->belongsTo('App\Zona', 'zona_id');
    }
}
