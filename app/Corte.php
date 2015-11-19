<?php

namespace App;


/**
 * App\Corte
 *
 * @property integer $id
 * @property float $fondo
 * @property float $fondo_reportado
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $empleado_id
 * @property integer $caja_id
 * @property integer $corte_global_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Corte[] $cortes
 * @property-read \App\Corte $corteGlobal
 * @property-read \App\Empleado $empleado
 * @property-read \App\Caja $caja
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GastoExtra[] $gastosExtras
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CorteDetalle[] $cortesDetalles
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereFondo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereFondoReportado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereCajaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereCorteGlobalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Corte whereDeletedAt($value)
 */
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
        parent::boot();
        Corte::creating(function ($model) {
            if (!empty($model->corte_global_id) && !is_numeric($model->corte_global_id)) return false;
            if (!empty($model->caja_id) && !is_numeric($model->caja_id)) return false;

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
        return $this->hasMany('App\Corte', 'corte_global_id');
    }

    /**
     * Obtiene los cortes asociados al corte global
     * @return App\Corte
     */
    public function corteGlobal() {
        return $this->belongsTo('App\Corte', 'corte_global_id');
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

    /**
     * Obtiene los gastos extras asociados al corte
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function gastosExtras() {
        return $this->hasMany('App\GastoExtra');
    }

    /**
     * Obtiene los detalles para el corte
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cortesDetalles() {
        return $this->hasMany('App\CorteDetalle');
    }

}
