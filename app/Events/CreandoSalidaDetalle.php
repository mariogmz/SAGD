<?php

namespace App\Events;

use App\Salida;
use App\SalidaDetalle;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreandoSalidaDetalle extends Event
{
    use SerializesModels;

    public $salida;
    public $salidaDetalle;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Salida $salida, SalidaDetalle $salidaDetalle)
    {
        $this->salida = $salida;
        $this->salidaDetalle = $salidaDetalle;
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
