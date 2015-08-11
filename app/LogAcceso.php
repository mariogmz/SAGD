<?php

namespace App;


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
