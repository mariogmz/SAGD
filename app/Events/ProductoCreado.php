<?php

namespace App\Events;

use App\Events\Event;
use App\Producto;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ProductoCreado extends Event
{
    use SerializesModels;
    public $producto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
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
