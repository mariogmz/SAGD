<?php

namespace App\Listeners;

use App\Events\CreandoSalidaDetalle;
use App\Producto;
use App\ProductoMovimiento;
use App\ProductoSucursal;
use App\Salida;
use App\SalidaDetalle;
use App\Sucursal;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CrearProductoMovimientoDesdeSalida
{

    protected $producto;
    protected $productoMovimiento;
    protected $productoSucursal;
    protected $salida;
    protected $salidaDetalle;
    protected $sucursal;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        Producto $producto, ProductoMovimiento $productoMovimiento,
        ProductoSucursal $productoSucursal,Salida $salida,
        SalidaDetalle $salidaDetalle, Sucursal $sucursal)
    {
        $this->producto = $producto;
        $this->productoMovimiento = $productoMovimiento;
        $this->productoSucursal = $productoSucursal;
        $this->salida = $salida;
        $this->salidaDetalle = $salidaDetalle;
        $this->sucursal = $sucursal;
    }

    /**
     * Handle the event.
     *
     * @param  CreandoSalidaDetalle  $event
     * @return bool|model
     */
    public function handle(CreandoSalidaDetalle $event)
    {
        $this->salida = $event->salida;
        $this->salidaDetalle = $event->salidaDetalle;
        $this->productoMovimiento = new ProductoMovimiento([
            'movimiento' => "Salida. Motivo: {$this->salidaDetalle->motivo}",
            'salieron' => $this->salidaDetalle->cantidad
        ]);

        $this->producto = $this->salidaDetalle->producto;
        $this->sucursal = $this->salida->sucursal;
        $this->productoSucursal = $this->producto->productosSucursales()
            ->where('sucursal_id', $this->sucursal->id)->first();

        if( $this->productoSucursal->movimientos()->save($this->productoMovimiento) ) {
            return [
                'success' => true,
                'producto_movimiento' => $this->productoMovimiento
            ];
        } else {
            return [
                'success' => false
            ];
        }
    }
}
