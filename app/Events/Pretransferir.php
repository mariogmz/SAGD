<?php

namespace App\Events;

use App\Producto;
use App\Sucursal;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Pretransferir extends Event
{
    use SerializesModels;
    public $producto;
    public $data;
    public $origen;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Producto $producto, $data, Sucursal $origen)
    {
        $this->producto = $producto;
        $this->data = $data;
        $this->origen = $origen;
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
