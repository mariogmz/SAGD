<?php

namespace App\Events;

use App\Events\Event;
use App\ProductoMovimiento;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreandoProductoMovimiento extends Event
{
    use SerializesModels;

    public $productoMovimiento;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProductoMovimiento $productoMovimiento)
    {
        $this->productoMovimiento = $productoMovimiento;
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
