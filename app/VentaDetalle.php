<?php

namespace App;


class VentaDetalle extends LGGModel {

    protected $table = "ventas_detalles";
    public $timestamps = false;
    protected $fillable = ['cantidad', 'descripcion', 'precio', 'venta_id', 'tipo_partida_id', 'producto_id', 'metodo_pago_id',
        'factura_id', 'nota_credito_id'];

    public static $rules = [
        'cantidad'                  => 'required|numeric|min:0',
        'descripcion'               => 'string|max:50',
        'precio'                    => 'required|numeric',
        'total'                     => 'required|numeric',
        'utilidad'                  => 'required|numeric',
        'fecha_expiracion_garantia' => 'date',
        'tiempo_garantia'           => 'required|integer|min:0',
        'venta_id'                  => 'required|integer',
        'tipo_partida_id'           => 'required|integer',
        'producto_id'               => 'integer',
        'metodo_pago_id'            => 'integer|required_with:producto_id',
        'factura_id'                => 'integer',
        'nota_credito_id'           => 'integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        VentaDetalle::creating(function ($model) {
            if (is_null($model->producto_id) && !is_null($model->metodo_pago_id)) return false;

            return $model->isValid()
            && $model->total == $model->cantidad * $model->precio;

        });
        VentaDetalle::updating(function ($model) {
            $model->updateRules = self::$rules;
            if (is_null($model->producto_id) && !is_null($model->metodo_pago_id)) return false;

            return $model->isValid('update')
            && $model->total == $model->cantidad * $model->precio;
        });
    }
}
