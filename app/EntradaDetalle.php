<?php

namespace App;


/**
 * App\EntradaDetalle
 *
 * @property integer $id
 * @property float $costo
 * @property integer $cantidad
 * @property float $importe
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $entrada_id
 * @property integer $producto_id
 * @property integer $sucursal_id
 * @property integer $producto_movimiento_id
 * @property-read \App\Entrada $entrada
 * @property-read \App\Producto $producto
 * @property-read \App\Sucursal $sucursal
 * @property-read \App\ProductoMovimiento $productoMovimiento
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereCosto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereImporte($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereEntradaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereProductoMovimientoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EntradaDetalle whereDeletedAt($value)
 */
class EntradaDetalle extends LGGModel {

    //
    protected $table = "entradas_detalles";
    public $timestamps = true;
    protected $fillable = ['costo', 'cantidad', 'importe',
        'entrada_id', 'producto_id', 'sucursal_id', 'producto_movimiento_id'];

    public static $rules = [
        'costo'                  => 'required|numeric|min:0.0',
        'cantidad'               => 'required|integer|min:0',
        'importe'                => 'required|numeric|min:0.0|mult:costo,cantidad',
        'entrada_id'             => 'required|integer',
        'producto_id'            => 'required|integer',
        'producto_movimiento_id' => 'integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EntradaDetalle::creating(function ($model) {
            $model->costo || $model->costo = 0.0;
            $model->cantidad || $model->cantidad = 0;
            $model->importe || $model->importe = $model->costo * $model->cantidad;
            return $model->isValid();
        });
        EntradaDetalle::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene la Entrada asociada con la Entrada Detalle
     * @return App\Entrada
     */
    public function entrada() {
        return $this->belongsTo('App\Entrada', 'entrada_id');
    }

    /**
     * Obtiene el Producto asociado con la Entrada Detalle
     * @return App\Producto
     */
    public function producto() {
        return $this->belongsTo('App\Producto', 'producto_id');
    }

    /**
     * Obtiene el Movimiento del Producto asociado con la Entrada Detalle
     * @return App\ProductoMovimiento
     */
    public function productoMovimiento() {
        return $this->belongsTo('App\ProductoMovimiento', 'producto_movimiento_id');
    }
}
