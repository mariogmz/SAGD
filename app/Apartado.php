<?php

namespace App;


/**
 * App\Apartado
 *
 * @property integer $id
 * @property string $fecha_apartado
 * @property string $fecha_desapartado
 * @property string $concepto
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $estado_apartado_id
 * @property integer $sucursal_id
 * @property integer $empleado_apartado_id
 * @property integer $empleado_desapartado_id
 * @property-read \App\EstadoApartado $estado
 * @property-read \App\Sucursal $sucursal
 * @property-read \App\Empleado $empleadoApartado
 * @property-read \App\Empleado $empleadoDesapartado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ApartadoDetalle[] $detalles
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereFechaApartado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereFechaDesapartado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereConcepto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereEstadoApartadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereEmpleadoApartadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Apartado whereEmpleadoDesapartadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Apartado extends LGGModel {

    //
    protected $table = "apartados";
    public $timestamps = true;
    protected $fillable = ['fecha_apartado', 'fecha_desapartado', 'concepto',
        'estado_apartado_id', 'sucursal_id', 'empleado_apartado_id', 'empleado_desapartado_id'];

    public static $rules = [
        'concepto'                => 'required|max:255',
        'fecha_apartado'          => 'date',
        'fecha_desapartado'       => 'date',
        'estado_apartado_id'      => 'required|integer',
        'sucursal_id'             => 'required|integer',
        'empleado_apartado_id'    => 'required|integer',
        'empleado_desapartado_id' => 'integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Apartado::creating(function ($model) {
            return $model->isValid();
        });
        Apartado::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene el Estado Apartado asociado con el Apartado
     * @return App\EstadoApartado
     */
    public function estado() {
        return $this->belongsTo('App\EstadoApartado', 'estado_apartado_id');
    }


    /**
     * Obtiene la Sucursal asociada con el Apartado
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
     * Obtiene el Empleado que Aparto asociado con el Apartado
     * @return App\Empleado
     */
    public function empleadoApartado() {
        return $this->belongsTo('App\Empleado', 'empleado_apartado_id');
    }


    /**
     * Obtiene el Empleado que Desaparto asociado con el Apartado
     * @return App\Empleado
     */
    public function empleadoDesapartado() {
        return $this->belongsTo('App\Empleado', 'empleado_desapartado_id');
    }


    /**
     * Obtiene el Apartado Detalle asociado con el Apartado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function detalles() {
        return $this->hasMany('App\ApartadoDetalle', 'apartado_id');
    }
}
