<?php

namespace App;


/**
 * App\EmpleadoPermiso
 *
 * @property integer $id_empleado
 * @method static \Illuminate\Database\Query\Builder|\App\EmpleadoPermiso whereIdEmpleado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class EmpleadoPermiso extends LGGModel {

    //
    protected $table = "empleados_permisos";
    public $timestamps = false;
    protected $fillable = ['id_empleado'];

    public static $rules = [
        'id_empleado' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        EmpleadoPermiso::creating(function ($model) {
            return $model->isValid();
        });
        EmpleadoPermiso::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }
}