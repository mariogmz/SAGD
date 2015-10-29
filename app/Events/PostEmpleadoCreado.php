<?php

namespace App\Events;

use App\Empleado;
use App\DatoContacto;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostEmpleadoCreado extends Event
{
    use SerializesModels;

    public $empleado;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DatoContacto $datoContacto)
    {
        $this->empleado = Empleado::find($datoContacto->empleado_id);
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
