<?php

namespace App;

use Event;
use App\ProductoSucursal;
use App\Existencia;
use App\Events\CreandoProductoMovimiento;

/**
 * App\ProductoMovimiento
 *
 * @property integer $id
 * @property string $movimiento
 * @property integer $entraron
 * @property integer $salieron
 * @property integer $existencias_antes
 * @property integer $existencias_despues
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $producto_id
 * @property-read \App\Producto $producto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RmaDetalle[] $rmaDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EntradaDetalle[] $entradasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SalidaDetalle[] $salidasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TransferenciaDetalle[] $transferenciasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ApartadoDetalle[] $apartadosDetalles
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereMovimiento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereEntraron($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereSalieron($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereExistenciasAntes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereExistenciasDespues($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property integer $producto_sucursal_id
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\ProductoSucursal $productoSucursal
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereProductoSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductoMovimiento whereDeletedAt($value)
 */
class ProductoMovimiento extends LGGModel {

    //
    protected $table = "productos_movimientos";
    public $timestamps = true;
    protected $fillable = ['movimiento', 'entraron', 'salieron',
        'existencias_antes', 'existencias_despues', 'producto_id', 'producto_sucursal_id'];

    public static $rules = [
        'movimiento'          => 'required|max:100',
        'entraron'            => 'integer|min:0',
        'salieron'            => 'integer|min:0',
        'existencias_antes'   => 'integer|min:0',
        'existencias_despues' => 'integer|min:0',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        ProductoMovimiento::creating(function ($pm) {
            $pm->entraron || $pm->entraron = 0;
            $pm->salieron || $pm->salieron = 0;

            $result = Event::fire(new CreandoProductoMovimiento($pm))[0];
            if ($result['success']) {
                $pm->existencias_antes || $pm->existencias_antes = $result['antes'];
                $pm->existencias_despues || $pm->existencias_despues = $result['despues'];
                return $pm->isValid();
            } else {
                return false;
            }
        });
        ProductoMovimiento::updating(function ($pm) {
            $pm->updateRules = self::$rules;
            return $pm->isValid('update');
        });
    }

    /**
     * Obtiene el Producto asociado al Movimiento
     * @return App\ProductoSucursal
     */
    public function productoSucursal() {
        return $this->belongsTo('App\ProductoSucursal');
    }

    /**
     * Obtiene el detalle del rma
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmaDetalles() {
        return $this->hasMany('App\RmaDetalle');
    }

    /**
     * Obtiene las Entradas Detalles asociadas con el Producto Movimiento
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function entradasDetalles() {
        return $this->hasMany('App\EntradaDetalle', 'producto_movimiento_id');
    }

    /**
     * Obtiene las Salidas Detalles asociadas con el Producto Movimiento
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function salidasDetalles() {
        return $this->hasMany('App\SalidaDetalle', 'producto_movimiento_id');
    }

    /**
     * Obtiene las Transferencias Detalles asociadas con el Producto Movimiento
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function transferenciasDetalles() {
        return $this->hasMany('App\TransferenciaDetalle', 'producto_movimiento_id');
    }

    /**
     * Obtiene los Apartados Detalles asociados con el Producto Movimiento
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function apartadosDetalles() {
        return $this->hasMany('App\ApartadoDetalle', 'producto_movimiento_id');
    }

    /**
     * Obtiene el producto al que pertenece
     * @return mixed
     */
    public function producto() {
        return $this->productoSucursal->producto();
    }

    /**
     * Obtiene la sucursal al que pertenece
     * @return mixed
     */
    public function sucursal() {
        return $this->productoSucursal->sucursal();
    }
}
