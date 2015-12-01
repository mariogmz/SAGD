<?php

namespace App\Listeners;

use App\Entrada;
use App\EntradaDetalle;
use App\Events\CargandoEntrada;
use App\Producto;
use App\ProductoMovimiento;
use App\ProductoSucursal;
use App\Sucursal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CrearProductoMovimientoDesdeEntrada
{

    protected $producto;
    protected $productoMovimiento;
    protected $productoSucursal;
    protected $entrada;
    protected $entradaDetalle;
    protected $sucursal;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        Producto $producto, ProductoMovimiento $productoMovimiento,
        ProductoSucursal $productoSucursal, Entrada $entrada,
        EntradaDetalle $entradaDetalle, Sucursal $sucursal)
    {
        $this->producto = $producto;
        $this->productoMovimiento = $productoMovimiento;
        $this->productoSucursal = $productoSucursal;
        $this->entrada = $entrada;
        $this->entradaDetalle = $entradaDetalle;
        $this->sucursal = $sucursal;
    }

    /**
     * Handle the event.
     *
     * @param  CargandoEntrada  $event
     * @return void
     */
    public function handle(CargandoEntrada $event)
    {
        $this->entrada = $event->entrada;
        $this->entradaDetalle = $event->entradaDetalle;
        $this->productoMovimiento = new ProductoMovimiento([
            'movimiento' => "Entrada. Entraron {$this->entradaDetalle->cantidad} productos.",
            'entraron' => $this->entradaDetalle->cantidad
        ]);

        $this->producto = $this->entradaDetalle->producto;
        $this->sucursal = $this->entrada->sucursal;
        $this->productoSucursal = $this->producto->productosSucursales()
            ->where('sucursal_id', $this->sucursal->id)->first();

        return $this->productoSucursal->movimientos()->save($this->productoMovimiento);
    }
}
