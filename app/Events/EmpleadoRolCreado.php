<?php

namespace App\Events;

use App\Empleado;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmpleadoRolCreado extends Event
{
    use SerializesModels;
    public $empleado;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Empleado $empleado)
    {
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
