<?php

namespace App;


use Sagd\CalculadoraPrecios;

/**
 * App\Precio
 *
 * @property integer $id
 * @property float $costo
 * @property float $precio_1
 * @property float $precio_2
 * @property float $precio_3
 * @property float $precio_4
 * @property float $precio_5
 * @property float $precio_6
 * @property float $precio_7
 * @property float $precio_8
 * @property float $precio_9
 * @property float $precio_10
 * @property float $descuento
 * @property boolean $revisado
 * @property integer $producto_sucursal_id
 * @property-read \App\ProductoSucursal $productoSucursal
 * @method static \Illuminate\Database\Query\Builder|\App\Precio whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio whereCosto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio4($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio6($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio7($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio8($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio9($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio wherePrecio10($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio whereProductoSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Precio whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio whereRevisado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Precio whereDescuento($value)
 */
class Precio extends LGGModel {

    use CalculadoraPrecios;

    protected $table = "precios";
    public $timestamps = false;
    protected $fillable = ['costo', 'precio_1', 'precio_2', 'precio_3',
        'precio_4', 'precio_5', 'precio_6', 'precio_7', 'precio_8', 'precio_9',
        'precio_10', 'descuento','revisado'];

    public static $rules = [
        'costo'                => 'required|numeric|min:0.1',
        'precio_1'             => 'required|numeric|min:0.1',
        'precio_2'             => 'required|numeric|less_than:precio_1',
        'precio_3'             => 'required|numeric|less_than:precio_2',
        'precio_4'             => 'required|numeric|less_than:precio_3',
        'precio_5'             => 'required|numeric|less_than:precio_4',
        'precio_6'             => 'required|numeric|less_than:precio_5',
        'precio_7'             => 'required|numeric|less_than:precio_6',
        'precio_8'             => 'required|numeric|less_than:precio_7',
        'precio_9'             => 'required|numeric|less_than:precio_8',
        'precio_10'            => 'required|numeric|less_than:precio_9',
        'revisado'             => 'boolean',
		'descuento'            => 'numeric|between:0.00,1.00',
        'producto_sucursal_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Precio::creating(function ($precio) {
            if (!$precio->isValid()) {
                return false;
            }

            return true;
        });
        Precio::updating(function ($precio) {
            $precio->updateRules = self::$rules;

            return $precio->isValid('update');
        });
    }

    /**
     * Obtiene el producto sucursal/proveedor asociado
     * @return \App\ProductoSucursal
     */
    public function productoSucursal() {
        return $this->belongsTo('App\ProductoSucursal', 'producto_sucursal_id');
    }

    /**
     * Obtiene el producto relacionado
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto() {
        return $this->productoSucursal->belongsTo('App\Producto', 'producto_id');
    }

    /**
     * Obtiene el proveedor al que pertenece este precio
     * @return \App\Proveedor
     */
    public function proveedor() {
        return $this->productoSucursal->sucursal->proveedor();
    }

}
