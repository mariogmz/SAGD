<?php

namespace App\Listeners;

use App\Existencia;
use App\Producto;
use App\ProductoSucursal;
use App\Sucursal;
use App\Events\Pretransferir;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EjecutarPretransferencia
{

    protected $producto;
    protected $data;
    protected $sucursalOrigen;
    protected $existenciaOrigen;
    protected $existenciaDestino;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Producto $producto, Sucursal $sucursal,
        Existencia $existenciaOrigen, Existencia $existenciaDestino,
        ProductoSucursal $productoSucursal)
    {
        $this->producto = $producto;
        $this->sucursalOrigen = $sucursal;
        $this->existenciaOrigen = $existenciaOrigen;
        $this->existenciaDestino = $existenciaDestino;
        $this->productoSucursal = $productoSucursal;
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

        return $this->actualizarExistencias() ? [true] : [false];
    }

    private function actualizarExistencias()
    {
        $this->existenciaOrigen = $this->producto->existencias($this->sucursalOrigen);
        $this->productoSucursal = $this->productoSucursal->find($this->data['id']);
        $this->existenciaDestino = $this->productoSucursal->existencia;

        $pretransferencia = (int)$this->data['pretransferencia'];

        if ($pretransferencia === 0) {
            $this->existenciaOrigen->errors = ['cantidad' => 'La cantidad es cero'];
            return $this->existenciaOrigen;
        }

        $this->existenciaOrigen->cantidad -= $pretransferencia;
        $this->existenciaOrigen->cantidad_pretransferencia += $pretransferencia;
        $this->existenciaDestino->cantidad_pretransferencia_destino += $pretransferencia;

        $successOrigen = $this->existenciaOrigen->save();
        $successDestino = $this->existenciaDestino->save();
        return $successOrigen && $successDestino;
    }
}
