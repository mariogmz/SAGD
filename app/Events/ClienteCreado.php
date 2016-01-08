<?php

namespace App\Events;


use App\Cliente;
use Illuminate\Queue\SerializesModels;

class ClienteCreado extends Event {

    use SerializesModels;
    public $cliente;
    public $datos;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    /**
     * Create a new event instance.
     * @param Cliente $cliente
     * @param array $datos
     */
    public function __construct(Cliente $cliente, array $datos) {
        $this->cliente = $cliente;
        $this->datos = $datos;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn() {
        return [];
    }
}
