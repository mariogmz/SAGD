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

        return $this->actualizarExistencias();
    }

    private function actualizarExistencias()
    {
        $this->existencia = $this->producto->existencias($this->sucursalOrigen);
        $pretransferencia = (int)$this->data['pretransferencia'];

        if ($pretransferencia === 0) {
            $this->existencia->errors = ['cantidad' => 'La cantidad es cero'];
            return $this->existencia;
        }

        $this->existencia->cantidad -= $pretransferencia;
        $this->existencia->cantidad_pretransferencia += $pretransferencia;
        if ($this->existencia->save()) {
            return true;
        } else {
            \Log::error("Existencia: " . $this->existencia);
            return $this->existencia;
        }
    }
}
