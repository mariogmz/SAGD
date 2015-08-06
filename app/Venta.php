<?php

namespace App;


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
        Venta::creating(function ($model) {
            return $model->isValid();
        });
        Venta::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el estatus asociado a esta venta
     * @return App\EstatusVenta
     */
    public function estatusVenta() {
        return $this->belongsTo('App\EstatusVenta', 'estatus_venta_id');
    }

    /**
     * Obtiene el tipo de venta asociado a la venta
     * @return App\TipoVenta
     */
    public function tipoVenta() {
        return $this->belongsTo('App\TipoVenta');
    }
}
