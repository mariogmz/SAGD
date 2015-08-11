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

    /**
     * Obtiene la venta asociada con esta partida
     * @return App\Venta
     */
    public function venta() {
        return $this->belongsTo('App\Venta');
    }

    /**
     * Obtiene el producto que se vendió en esta partida
     * @return App\Producto
     */
    public function producto() {
        return $this->belongsTo('App\Producto');
    }

    /**
     * Obtiene el tipo de la partida asociado
     * @return App\TipoPartida
     */
    public function tipoPartida() {
        return $this->belongsTo('App\TipoPartida');
    }

    /**
     * Obtiene el metodo de pago que se utilizó en este detalle
     * @return App\MetodoPago
     */
    public function metodoPago() {
        return $this->belongsTo('App\MetodoPago');
    }

    /**
     * Obtiene la factura donde se encuentra incluido este detalle de venta
     * @return App\Factura
     */
    public function factura() {
        return $this->belongsTo('App\Factura');
    }

    /**
     * Obtiene la nota de credito donde se encuentra incluido este detalle de venta
     * @return App\NotaCredito
     */
    public function notaCredito() {
        return $this->belongsTo('App\NotaCredito');
    }

    /**
     * Obtiene las garantias asociadas al detalle de la venta
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function garantias() {
        return $this->hasMany('App\Garantia');
    }

}
