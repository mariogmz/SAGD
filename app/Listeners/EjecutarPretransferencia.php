<?php

namespace App\Listeners;

use App\Empleado;
use App\Existencia;
use App\Pretransferencia;
use App\Producto;
use App\ProductoMovimiento;
use App\ProductoSucursal;
use App\Sucursal;
use App\Events\Pretransferir;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EjecutarPretransferencia
{

    protected $data;
    protected $existenciaDestino;
    protected $existenciaOrigen;
    protected $pretransferencia;
    protected $producto;
    protected $sucursalDestino;
    protected $sucursalOrigen;
    protected $empleado;
    protected $productoMovimiento;
    protected $cantidad;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        Producto $producto, Sucursal $sucursal,
        Existencia $existenciaOrigen, Existencia $existenciaDestino,
        ProductoSucursal $productoSucursal, Pretransferencia $pretransferencia,
        ProductoMovimiento $productoMovimiento, Empleado $empleado)
    {
        $this->producto = $producto;
        $this->sucursalOrigen = $sucursal;
        $this->sucursalDestino = $sucursal;
        $this->existenciaOrigen = $existenciaOrigen;
        $this->existenciaDestino = $existenciaDestino;
        $this->productoSucursal = $productoSucursal;
        $this->pretransferencia = $pretransferencia;
        $this->productoMovimiento = $productoMovimiento;
        $this->empleado = $empleado;
    }

    /**
     * Handle the event.
     *
     * @param  Pretransferir  $event
     * @return void
     */
    public function handle(Pretransferir $event)
    {
        $this->producto = $event->producto;
        $this->data = $event->data;
        $this->sucursalOrigen = $event->origen;
        $this->empleado = $event->empleado;

        return $this->actualizarExistencias() ? [true] : [false];
    }

    private function actualizarExistencias()
    {
        $this->obtenerSucursalDestino();
        $this->asignarExistencias();

        $pretransferencia = (int)$this->data['pretransferencia'];

        if ($pretransferencia === 0) {
            $this->existenciaOrigen->errors = ['cantidad' => 'La cantidad es cero'];
            return $this->existenciaOrigen;
        }
        $this->cantidad = $pretransferencia;
        $this->alterarExistencias();
        $this->generarPretransferencia();

        return $this->guardarModelos();
    }

    private function asignarExistencias()
    {
        $this->existenciaOrigen = $this->producto->existencias($this->sucursalOrigen);
        $this->existenciaDestino = $this->productoSucursal->existencia;
    }

    private function obtenerSucursalDestino()
    {
        $this->productoSucursal = $this->productoSucursal->find($this->data['id']);
        $this->sucursalDestino = $this->productoSucursal->sucursal;
    }

    private function alterarExistencias()
    {
        $this->existenciaOrigen->cantidad -= $this->cantidad;
        $this->existenciaOrigen->cantidad_pretransferencia += $this->cantidad;
        $this->existenciaDestino->cantidad_pretransferencia_destino += $this->cantidad;
    }

    private function generarPretransferencia()
    {
        $this->pretransferencia->producto()->associate($this->producto);
        $this->pretransferencia->origen()->associate($this->sucursalOrigen);
        $this->pretransferencia->destino()->associate($this->sucursalDestino);
        $this->pretransferencia->empleado()->associate($this->empleado);
        $this->pretransferencia->cantidad = $this->cantidad;
    }

    private function guardarModelos()
    {
        $successOrigen = $this->existenciaOrigen->save();
        $successDestino = $this->existenciaDestino->save();
        $successPretransferencia = $this->pretransferencia->save();
        $successMovimientos = $this->generarMovimientos($successOrigen, $successDestino);
        return $successOrigen && $successDestino && $successPretransferencia;
    }

    private function generarMovimientos($successOrigen, $successDestino)
    {
        if(!$successOrigen || !$successDestino) { return false; }

        $this->productoMovimiento->movimiento = "Pretransferencia salida";
        $this->productoMovimiento->entraron = $this->cantidad;
        $this->productoMovimiento->salieron = $this->cantidad;
        $this->productoMovimiento->existencias_antes = $this->existenciaOrigen->cantidad_pretransferencia - $this->cantidad;
        $this->productoMovimiento->existencias_despues = $this->existenciaOrigen->cantidad_pretransferencia;

        $this->productoMovimiento->productoSucursal()
            ->associate($this->existenciaOrigen->productoSucursal);

        return $this->productoMovimiento->save();
    }
}
