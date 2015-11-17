<?php

namespace App;


/**
 * App\Venta
 *
 * @property integer $id
 * @property float $total
 * @property float $pago
 * @property float $utilidad
 * @property string $fecha_cobro
 * @property integer $tabulador
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $sucursal_id
 * @property integer $cliente_id
 * @property integer $caja_id
 * @property integer $corte_id
 * @property integer $estatus_venta_id
 * @property integer $estado_venta_id
 * @property integer $tipo_venta_id
 * @property integer $sucursal_entrega_id
 * @property integer $empleado_id
 * @property-read \App\Sucursal $sucursal
 * @property-read \App\Cliente $cliente
 * @property-read \App\Caja $caja
 * @property-read \App\Corte $corte
 * @property-read \App\EstatusVenta $estatusVenta
 * @property-read \App\EstadoVenta $estadoVenta
 * @property-read \App\TipoVenta $tipoVenta
 * @property-read \App\Sucursal $sucursalEntrega
 * @property-read \App\Empleado $empleado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VentaDetalle[] $ventasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Anticipo[] $anticipos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Anticipo[] $anticiposEntrega
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VentaMovimiento[] $ventasMovimientos
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta wherePago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereUtilidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereFechaCobro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereTabulador($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereCajaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereCorteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereEstatusVentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereEstadoVentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereTipoVentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereSucursalEntregaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Venta whereDeletedAt($value)
 */
class Venta extends LGGModel {

    protected $table = "ventas";
    public $timestamps = true;
    protected $fillable = [
        'total',
        'pago',
        'utilidad',
        'fecha_cobro',
        'tabulador',
        'sucursal_id',
        'cliente_id',
        'caja_id',
        'corte_id',
        'estatus_venta',
        'estado_venta',
        'tipo_venta_id',
        'sucursal_entrega_id',
        'empleado_id'
    ];

    public static $rules = [
        'total'               => 'numeric',
        'pago'                => 'numeric|greater_than:total',
        'utilidad'            => 'numeric|greater_than:0',
        'fecha_cobro'         => 'date',
        'tabulador'           => 'integer|between:1,10',
        'sucursal_id'         => 'required|integer',
        'cliente_id'          => 'required|integer',
        'caja_id'             => 'required|integer',
        'corte_id'            => 'integer',
        'estatus_venta_id'    => 'required|integer',
        'estado_venta_id'     => 'required|integer',
        'tipo_venta_id'       => 'required|integer',
        'sucursal_entrega_id' => 'required|integer',
        'empleado_id'         => 'integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Venta::creating(function ($model) {
            return $model->isValid();
        });
        Venta::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene la sucursal en la cual fue realizada la venta
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene el cliente de la venta
     * @return App\Cliente
     */
    public function cliente() {
        return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtiene la caja en la cual se realizó la venta
     * @return App\Caja
     */
    public function caja() {
        return $this->belongsTo('App\Caja');
    }

    /**
     * Obtiene el corte en el cual fué incluido esta venta
     * @return App\Corte
     */
    public function corte() {
        return $this->belongsTo('App\Corte');
    }

    /**
     * Obtiene el estatus de la venta
     * @return App\EstatusVenta
     */
    public function estatusVenta() {
        return $this->belongsTo('App\EstatusVenta');
    }

    /**
     * Obtiene el estado de la venta
     * @return App\EstadoVenta
     */
    public function estadoVenta() {
        return $this->belongsTo('App\EstadoVenta');
    }

    /**
     * Obtiene el tipo de la venta
     * @return App\TipoVenta
     */
    public function tipoVenta() {
        return $this->belongsTo('App\TipoVenta');
    }

    /**
     * Obtiene la sucursal en la cual fué entregada la mercancía de la venta
     * @return App\Sucursal
     */
    public function sucursalEntrega() {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene el empleado que realizó la venta / o quién le dió seguimiento
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado');
    }

    /**
     * Obtiene los detalles de la venta
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventasDetalles() {
        return $this->hasMany('App\VentaDetalle');
    }

    /**
     * Obtiene los anticipos asociados a la venta
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function anticipos() {
        return $this->hasMany('App\Anticipo');
    }

    /**
     * Obtiene los anticipos asociados a la venta de entrega
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function anticiposEntrega() {
        return $this->hasMany('App\Anticipo', 'venta_entrega_id');
    }

    /**
     * Obtiene todos los movimientos asociados a la venta
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventasMovimientos() {
        return $this->hasMany('App\VentaMovimiento');
    }

}
