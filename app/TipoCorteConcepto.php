<?php

namespace App;


/**
 * App\TipoCorteConcepto
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CorteConcepto[] $cortesConceptos
 * @method static \Illuminate\Database\Query\Builder|\App\TipoCorteConcepto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoCorteConcepto whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class TipoCorteConcepto extends LGGModel {

    protected $table = "tipos_cortes_conceptos";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|string|max:45'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        TipoCorteConcepto::creating(function ($model) {
            return $model->isValid();
        });
        TipoCorteConcepto::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene todos los conceptos asociados a este tipo
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function cortesConceptos() {
        return $this->hasMany('App\CorteConcepto');
    }
}
