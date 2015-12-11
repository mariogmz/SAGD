<?php

namespace App\Listeners;

use App\Existencia;
use App\Producto;
use App\ProductoMovimiento;
use App\ProductoSucursal;
use App\Sucursal;
use App\Transferencia;
use App\TransferenciaDetalle;
use App\Events\Transferir;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EjecutarTransferencia
{
    protected $existencia;
    protected $producto;
    protected $productoMovimiento;
    protected $productoSucursal;
    protected $sucursalOrigen;
    protected $transferencia;
    protected $detalle;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Existencia $existencia, Producto $producto,
        ProductoMovimiento $productoMovimiento, ProductoSucursal $productoSucursal,
        Sucursal $sucursal, Transferencia $transferencia, TransferenciaDetalle $detalle)
    {
        $this->existencia = $existencia;
        $this->producto = $producto;
        $this->productoMovimiento = $productoMovimiento;
        $this->productoSucursal = $productoSucursal;
        $this->sucursalOrigen = $sucursal;
        $this->transferencia = $transferencia;
        $this->detalle = $detalle;
    }

    /**
     * Handle the event.
     *
     * @param  Transferir  $event
     * @return void
     */
    public function handle(Transferir $event)
    {
        $this->transferencia = $event->transferencia;
        $this->sucursalOrigen = $this->transferencia->sucursalOrigen;

        return $this->realizarTransferenciaDeProductos() ? true : [false];
    }

    private function realizarTransferenciaDeProductos()
    {
        foreach ($this->transferencia->detalles as $this->detalle) {
            $this->producto = $this->detalle->producto;
            $this->productoSucursal = $this->producto->productosSucursales()
                ->where('sucursal_id', $this->sucursalOrigen->id)->first();
            $this->existencia = $this->productoSucursal->existencia;

            $this->crearProductoMovimiento();
            $this->ajustarExistencias();

            if (! $this->actualizarModelos()) {
                return false;
            }
        }
        return true;
    }

    private function crearProductoMovimiento()
    {
        $this->productoMovimiento->movimiento = "Transferencia {$this->transferencia->id}";
        $this->productoMovimiento->entraron = 0;
        $this->productoMovimiento->salieron = $this->detalle->cantidad;
        $this->productoMovimiento->existencias_antes = $this->existencia->cantidad + $this->detalle->cantidad;
        $this->productoMovimiento->existencias_despues = $this->existencia->cantidad;
        $this->productoMovimiento->productoSucursal()->associate($this->productoSucursal);
    }

    private function ajustarExistencias()
    {
        $this->existencia->cantidad_pretransferencia -= $this->detalle->cantidad;
        $this->existencia->cantidad_transferencia += $this->detalle->cantidad;
    }

    private function actualizarModelos()
    {
        $successProductoMovimiento = $this->productoMovimiento->save();
        $successExistencia = $this->existencia->save();

        return $successProductoMovimiento && $successExistencia;
    }
}
