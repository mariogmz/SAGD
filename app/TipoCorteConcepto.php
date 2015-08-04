<?php

namespace App;


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
