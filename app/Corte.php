<?php

namespace App;


class Corte extends LGGModel {

    protected $table = "cortes";
    public $timestamps = true;
    protected $fillable = ['fondo', 'fondo_reportado', 'caja_id', 'empleado_id', 'corte_global_id'];

    public static $rules = [
        'fondo'           => 'required|numeric',
        'fondo_reportado' => 'numeric',
        'empleado_id'     => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Corte::creating(function ($model) {
            if(!empty($model->corte_global_id) && !is_numeric($model->corte_global_id)) return false;
            if(!empty($model->caja_id) && !is_numeric($model->caja_id)) return false;
            return $model->isValid();
        });
        Corte::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene los cortes asociados al corte global
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cortes() {
        return $this->hasMany('App\Corte','corte_global_id');
    }

    /**
     * Obtiene los cortes asociados al corte global
     * @return App\Corte
     */
    public function corteGlobal() {
        return $this->belongsTo('App\Corte','corte_global_id');
    }

    /**
     * Obtiene el empleado que realizó el corte
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado');
    }

    /**
     * Obtiene la caja asociada al corte
     * @return App\Caja
     */
    public function caja() {
        return $this->belongsTo('App\Caja');
    }
}
