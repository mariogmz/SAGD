<?php

namespace App;


/**
 * App\LogAcceso
 *
 * @property integer $id
 * @property boolean $exitoso
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $empleado_id
 * @property-read \App\Empleado $empleado
 * @method static \Illuminate\Database\Query\Builder|\App\LogAcceso whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LogAcceso whereExitoso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LogAcceso whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LogAcceso whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LogAcceso whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class LogAcceso extends LGGModel {

    protected $table = 'log_acceso';
    public $timestamps = true;

    protected $fillable = ['empleado_id', 'exitoso'];
    public static $rules = [
        'empleado_id' => 'required|numeric',
        'exitoso'     => 'required|boolean'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        LogAcceso::creating(function ($log_entry) {
            if (!$log_entry->isValid()) {
                return false;
            }

            return true;
        });
        LogAcceso::updating(function ($log_entry) {
            $log_entry->updateRules = self::$rules;

            return $log_entry->isValid();
        });
    }

    /**
     * Obtiene el empleado al que está asociado el registro del log
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado');
    }

}
