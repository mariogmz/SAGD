<?php

namespace App;


/**
 * App\Transferencia
 *
 * @property integer $id
 * @property string $fecha_transferencia
 * @property string $fecha_recepcion
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $sucursal_origen_id
 * @property integer $sucursal_destino_id
 * @property integer $empleado_origen_id
 * @property integer $empleado_destino_id
 * @property integer $empleado_revision_id
 * @property integer $estado_transferencia_id
 * @property-read \App\EstadoTransferencia $estado
 * @property-read \App\Sucursal $sucursalOrigen
 * @property-read \App\Sucursal $sucursalDestino
 * @property-read \App\Empleado $empleadoOrigen
 * @property-read \App\Empleado $empleadoDestino
 * @property-read \App\Empleado $empleadoRevision
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TransferenciaDetalle[] $detalles
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereFechaTransferencia($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereFechaRecepcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereSucursalOrigenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereSucursalDestinoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereEmpleadoOrigenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereEmpleadoDestinoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereEmpleadoRevisionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transferencia whereEstadoTransferenciaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Transferencia extends LGGModel {

    //
    protected $table = "transferencias";
    public $timestamps = true;
    protected $fillable = ['fecha_transferencia', 'fecha_recepcion',
        'estado_transferencia_id', 'sucursal_origen_id', 'sucursal_destino_id',
        'empleado_origen_id', 'empleado_destino_id', 'empleado_revision_id'];

    public static $rules = [
        'fecha_transferencia'     => 'date',
        'fecha_recepcion'         => 'date',
        'estado_transferencia_id' => 'integer',
        'sucursal_origen_id'      => 'required|integer',
        'sucursal_destino_id'     => 'required|integer',
        'empleado_origen_id'      => 'required|integer',
        'empleado_destino_id'     => 'integer',
        'empleado_revision_id'    => 'integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Transferencia::creating(function ($model) {
            return $model->isValid();
        });
        Transferencia::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el Estado Transferencia asociado con la Transferencia
     * @return App\EstadoTransferencia
     */
    public function estado() {
        return $this->belongsTo('App\EstadoTransferencia', 'estado_transferencia_id');
    }

    /**
     * Obtiene la Sucursal Origen asociada con la Transferencia
     * @return App\Sucursal
     */
    public function sucursalOrigen() {
        return $this->belongsTo('App\Sucursal', 'sucursal_origen_id');
    }

    /**
     * Obtiene la Sucursal Destino asociada con la Transferencia
     * @return App\Sucursal
     */
    public function sucursalDestino() {
        return $this->belongsTo('App\Sucursal', 'sucursal_destino_id');
    }

    /**
     * Obtiene el Empleado Origen asociado con la Transferencia
     * @return App\Empleado
     */
    public function empleadoOrigen() {
        return $this->belongsTo('App\Empleado', 'empleado_origen_id');
    }

    /**
     * Obtiene el Empleado Destino asociado con la Transferencia
     * @return App\Empleado
     */
    public function empleadoDestino() {
        return $this->belongsTo('App\Empleado', 'empleado_destino_id');
    }

    /**
     * Obtiene el Empleado Revision asociado con la Transferencia
     * @return App\Empleado
     */
    public function empleadoRevision() {
        return $this->belongsTo('App\Empleado', 'empleado_revision_id');
    }


    /**
     * Obtiene las Transferencias Detalles asociado con la Transferencia
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function detalles() {
        return $this->hasMany('App\TransferenciaDetalle', 'transferencia_id');
    }
}