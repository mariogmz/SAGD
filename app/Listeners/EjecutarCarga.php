<?php

namespace App\Listeners;

use App\Existencia;
use App\Producto;
use App\ProductoMovimiento;
use App\ProductoSucursal;
use App\Sucursal;
use App\Transferencia;
use App\TransferenciaDetalle;
use App\Events\Cargar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EjecutarCarga
{
    protected $existenciaOrigen;
    protected $existenciaDestino;
    protected $producto;
    protected $productoMovimiento;
    protected $productoSucursalOrigen;
    protected $productoSucursalDestino;
    protected $sucursalOrigen;
    protected $sucursalDestino;
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
        $this->existenciaOrigen = $existencia;
        $this->existenciaDestino = $existencia;
        $this->producto = $producto;
        $this->productoMovimiento = $productoMovimiento;
        $this->productoSucursalOrigen = $productoSucursal;
        $this->productoSucursalDestino = $productoSucursal;
        $this->sucursalOrigen = $sucursal;
        $this->sucursalDestino = $sucursal;
        $this->transferencia = $transferencia;
        $this->detalle = $detalle;
    }

    /**
     * Handle the event.
     *
     * @param  Cargar  $event
     * @return void
     */
    public function handle(Cargar $event)
    {
        $this->transferencia = $event->transferencia;
        $this->sucursalOrigen = $this->transferencia->sucursalOrigen;
        $this->sucursalDestino = $this->transferencia->sucursalDestino;

        return $this->realizarCargaDeProductos() ? true : [false];
    }

    private function realizarCargaDeProductos()
    {
        foreach ($this->transferencia->detalles as $this->detalle) {
            $this->producto = $this->detalle->producto;

            $this->productoSucursalDestino = $this->producto->productosSucursales()
                ->where('sucursal_id', $this->sucursalDestino->id)->first();
            $this->productoSucursalOrigen = $this->producto->productosSucursales()
                ->where('sucursal_id', $this->sucursalOrigen->id)->first();

            $this->existenciaOrigen = $this->productoSucursalOrigen->existencia;
            $this->existenciaDestino = $this->productoSucursalDestino->existencia;

            $this->crearProductoMovimiento();
            $this->ajustarExistenciasOrigen();
            $this->ajustarExistenciasDestino();

            if (! $this->actualizarModelos()) {
                return false;
            }
        }
        return true;
    }

    private function crearProductoMovimiento()
    {
        $this->productoMovimiento->movimiento = "Transferencia {$this->transferencia->id}";
        $this->productoMovimiento->entraron = $this->detalle->cantidad;
        $this->productoMovimiento->salieron = 0;
        $this->productoMovimiento->existencias_antes = $this->existenciaDestino->cantidad;
        $this->productoMovimiento->existencias_despues = $this->existenciaDestino->cantidad + $this->detalle->cantidad;
        $this->productoMovimiento->productoSucursal()->associate($this->productoSucursalDestino);
    }

    private function ajustarExistenciasOrigen()
    {
        $this->existenciaOrigen->cantidad_transferencia -= $this->detalle->cantidad;
    }

    private function ajustarExistenciasDestino()
    {
        $this->existenciaDestino->cantidad += $this->detalle->cantidad;
        $this->existenciaDestino->cantidad_pretransferencia_destino -= $this->detalle->cantidad;
    }

    private function actualizarModelos()
    {
        $successProductoMovimiento = $this->productoMovimiento->save();
        $successExistenciaOrigen = $this->existenciaOrigen->save();
        $successExistenciaDestino = $this->existenciaDestino->save();

        return $successProductoMovimiento && $successExistenciaOrigen && $successExistenciaDestino;
    }
}
