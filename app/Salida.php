<?php

namespace App;


/**
 * App\Salida
 *
 * @property integer $id
 * @property string $fecha_salida
 * @property string $motivo
 * @property integer $empleado_id
 * @property integer $sucursal_id
 * @property integer $estado_salida_id
 * @property-read \App\Empleado $empleado
 * @property-read \App\Sucursal $sucursal
 * @property-read \App\EstadoSalida $estado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SalidaDetalle[] $detalles
 * @method static \Illuminate\Database\Query\Builder|\App\Salida whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Salida whereFechaSalida($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Salida whereMotivo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Salida whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Salida whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Salida whereEstadoSalidaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Salida extends LGGModel {

    //
    protected $table = "salidas";
    public $timestamps = false;
    protected $fillable = ['fecha_salida', 'motivo',
        'empleado_id', 'sucursal_id', 'estado_salida_id'];

    public static $rules = [
        'fecha_salida'     => 'date',
        'motivo'           => 'required|max:255',
        'empleado_id'      => 'required|integer',
        'sucursal_id'      => 'required|integer',
        'estado_salida_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Salida::creating(function ($model) {
            return $model->isValid();
        });
        Salida::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene el Empleado asociado con la Salida
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }


    /**
     * Obtiene la Sucursal asociada con la Salida
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
     * Obtiene el Estado asociado con la Salida
     * @return App\EstadoSalida
     */
    public function estado() {
        return $this->belongsTo('App\EstadoSalida', 'estado_salida_id');
    }


    /**
     * Obtiene las Salidas Detalles asociadas con la Salida
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function detalles() {
        return $this->hasMany('App\SalidaDetalle', 'salida_id');
    }
}
