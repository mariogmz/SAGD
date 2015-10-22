<?php

namespace App\Events;

use App\Sucursal;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SucursalNueva extends Event
{
    use SerializesModels;
    public $sucursal;
    public $base;


    /**
     * Create a new event instance.
     *
     * @param Sucursal $sucursal
     * @param int base
     * @return void
     */
    public function __construct(Sucursal $sucursal, $base)
    {
        $this->sucursal = $sucursal;
        $this->base = $base;
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
