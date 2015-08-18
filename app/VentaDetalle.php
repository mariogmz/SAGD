<?php

namespace App;


/**
 * App\VentaDetalle
 *
 * @property integer $id
 * @property integer $cantidad
 * @property string $descripcion
 * @property float $precio
 * @property float $total
 * @property float $utilidad
 * @property string $fecha_expiracion_garantia
 * @property integer $tiempo_garantia
 * @property integer $venta_id
 * @property integer $tipo_partida_id
 * @property integer $producto_id
 * @property integer $metodo_pago_id
 * @property integer $factura_id
 * @property integer $nota_credito_id
 * @property-read \App\Venta $venta
 * @property-read \App\Producto $producto
 * @property-read \App\TipoPartida $tipoPartida
 * @property-read \App\MetodoPago $metodoPago
 * @property-read \App\Factura $factura
 * @property-read \App\NotaCredito $notaCredito
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Garantia[] $garantias
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle wherePrecio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereUtilidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereFechaExpiracionGarantia($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereTiempoGarantia($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereVentaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereTipoPartidaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereMetodoPagoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereFacturaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VentaDetalle whereNotaCreditoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
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
