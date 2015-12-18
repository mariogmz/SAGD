<?php

namespace App\Events;


use App\Cliente;
use Illuminate\Queue\SerializesModels;

class ClienteCreado extends Event {

    use SerializesModels;
    public $cliente;
    public $valor_tabulador;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    /**
     * Create a new event instance.
     * @param Cliente $cliente
     * @param int $valor_tabulador
     */
    public function __construct(Cliente $cliente, $valor_tabulador) {
        $this->cliente = $cliente;
        $this->valor_tabulador = $valor_tabulador;
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
