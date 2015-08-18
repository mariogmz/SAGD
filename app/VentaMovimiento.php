<?php

namespace App;


/**
 * App\VentaMovimiento
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $venta_id
 * @property integer $empleado_id
 * @property integer $estatus_venta_id
 * @property integer $estado_venta_id
 * @property-read \App\Venta $venta
 * @property-read \App\Empleado $empleado
 * @property-read \App\EstatusVenta $estatusVenta
 * @property-read \App\EstadoVenta $estadoVenta
 * @method static \Illuminate\Database\Query\Builder|\App\VentaMovimiento whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaMovimiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaMovimiento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaMovimiento whereVentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaMovimiento whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaMovimiento whereEstatusVentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaMovimiento whereEstadoVentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class VentaMovimiento extends LGGModel {

    protected $table = "ventas_movimientos";
    public $timestamps = true;
    protected $fillable = ['venta_id', 'empleado_id', 'estatus_venta_id', 'estado_venta_id'];

    public static $rules = [
        'venta_id'         => 'required|integer',
        'empleado_id'      => 'required|integer',
        'estatus_venta_id' => 'required|integer',
        'estado_venta_id'  => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        VentaMovimiento::creating(function ($model) {
            return $model->isValid();
        });
        VentaMovimiento::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene la venta a la que está asociada el movimiento
     * @return App\Venta
     */
    public function venta() {
        return $this->belongsTo('App\Venta');
    }

    /**
     * Obtiene el empleado que está asociado al movimiento
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado');
    }

    /**
     * Obtiene el estatus de venta asociado al movimiento
     * @return App\EstatusVenta
     */
    public function estatusVenta() {
        return $this->belongsTo('App\EstatusVenta');
    }

    /**
     * Obtiene el estado de venta asociado al movimiento
     * @return App\EstadoVenta
     */
    public function estadoVenta() {
        return $this->belongsTo('App\EstadoVenta');
    }
}
