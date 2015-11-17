<?php

namespace App;


/**
 * App\CorteConcepto
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $tipo_corte_concepto_id
 * @property-read \App\TipoCorteConcepto $tipoCorteConcepto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CorteDetalle[] $cortesDetalles
 * @method static \Illuminate\Database\Query\Builder|\App\CorteConcepto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CorteConcepto whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CorteConcepto whereTipoCorteConceptoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\CorteConcepto whereDeletedAt($value)
 */
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
        parent::boot();
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

    /**
     * Obtiene los detalles asociados a este tipo de concepto
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cortesDetalles() {
        return $this->hasMany('App\CorteDetalle');
    }


}
