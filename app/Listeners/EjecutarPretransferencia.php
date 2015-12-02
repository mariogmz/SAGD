<?php

namespace App\Listeners;

use App\Existencia;
use App\Producto;
use App\Sucursal;
use App\Events\Pretransferir;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EjecutarPretransferencia
{

    protected $producto;
    protected $data;
    protected $sucursalOrigen;
    protected $existencia;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Producto $producto, Sucursal $sucursal, Existencia $existencia)
    {
        $this->producto = $producto;
        $this->sucursalOrigen = $sucursal;
        $this->existencia = $existencia;
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

        $this->actualizarExistencias();
    }

    private function actualizarExistencias()
    {
        $this->existencia = $this->producto->existencias($this->sucursalOrigen);
        $this->existencia->cantidad -= $this->data['pretransferencia'];
        $this->existencia->cantidad_pretransferencia += $this->data['pretransferencia'];

        if ($this->existencia->save()) {
            return true;
        } else {
            return $this->existencia;
        }
    }
}
