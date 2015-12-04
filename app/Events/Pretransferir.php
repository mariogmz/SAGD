<?php

namespace App\Events;

use App\Producto;
use App\Sucursal;
use App\Empleado;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Pretransferir extends Event
{
    use SerializesModels;
    public $producto;
    public $data;
    public $origen;
    public $empleado;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Producto $producto, $data, Sucursal $origen, Empleado $empleado)
    {
        $this->producto = $producto;
        $this->data = $data;
        $this->origen = $origen;
        $this->empleado = $empleado;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
