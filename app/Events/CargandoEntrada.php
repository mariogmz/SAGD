<?php

namespace App\Events;

use App\Entrada;
use App\EntradaDetalle;
use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CargandoEntrada extends Event
{
    use SerializesModels;
    public $entrada;
    public $entradaDetalle;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EntradaDetalle $entradaDetalle, Entrada $entrada)
    {
        $this->entrada = $entrada;
        $this->entradaDetalle = $entradaDetalle;
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
