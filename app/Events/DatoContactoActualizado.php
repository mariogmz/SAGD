<?php

namespace App\Events;

use App\DatoContacto;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DatoContactoActualizado extends Event
{
    use SerializesModels;

    public $datoContacto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DatoContacto $datoContacto)
    {
        $this->datoContacto = $datoContacto;
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
