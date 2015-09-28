<?php

namespace App;


/**
 * App\Rma
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $estado_rma_id
 * @property integer $cliente_id
 * @property integer $empleado_id
 * @property integer $rma_tiempo_id
 * @property integer $sucursal_id
 * @property integer $nota_credito_id
 * @property-read \App\Cliente $cliente
 * @property-read \App\Empleado $empleado
 * @property-read \App\EstadoRma $estadoRma
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RmaDetalle[] $rmasDetalles
 * @property-read \App\RmaTiempo $rmaTiempo
 * @property-read \App\Sucursal $sucursal
 * @property-read \App\NotaCredito $notaCredito
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereEstadoRmaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereRmaTiempoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rma whereNotaCreditoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Rma extends LGGModel {

    protected $table = "rmas";
    public $timestamps = true;
    protected $fillable = ['estado_rma_id', 'cliente_id', 'empleado_id', 'rma_tiempo_id', 'sucursal_id', 'nota_credito_id'];

    public static $rules = [
        'estado_rma_id'   => 'required|integer',
        'cliente_id'      => 'required|integer',
        'empleado_id'     => 'required|integer',
        'rma_tiempo_id'   => 'required|integer',
        'sucursal_id'     => 'required|integer',
        'nota_credito_id' => 'integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Rma::creating(function ($model) {
            if (!$model->isValid()) {
                return false;
            }

            return true;
        });
        Rma::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid();
        });
    }

    /**
     * Obtiene el cliente al que se le está aplicando el RMA
     * @return App\Cliente
     */
    public function cliente() {
        return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtiene el empleado que está aplicando el RMA
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado');
    }

    /**
     * Obtiene el estado del rma asociado
     * @return App\EstadoRma
     */
    public function estadoRma() {
        return $this->belongsTo('App\EstadoRma');
    }

    /**
     * Obtiene el detalle del rma
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmasDetalles() {
        return $this->hasMany('App\RmaDetalle');
    }

    /**
     * Obtiene el tiempo de rma asociado
     * @return App\RmaTiempo
     */
    public function rmaTiempo() {
        return $this->belongsTo('App\RmaTiempo');
    }

    /**
     * Obtiene el estado del rma asociado
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene la nota de crédito asociada con el RMA
     * @return App\NotaCredito
     */
    public function notaCredito() {
        return $this->belongsTo('App\NotaCredito');
    }
}
