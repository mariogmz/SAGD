<?php

namespace App\Listeners;


use App\Cliente;
use App\Events\ClienteCreado;
use App\Sucursal;
use App\Tabulador;

class CrearTabuladoresParaClienteNuevo {

    protected $cliente;
    protected $valor_tabulador;

    /**
     * Create event listener
     * @param Cliente $cliente
     */
    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    /**
     * Handle the event.
     *
     * @param  ClienteCreado $event
     * @return void
     */
    public function handle(ClienteCreado $event) {
        $this->cliente = $event->cliente;
        $this->valor_tabulador = $event->datos;
        $this->agregarTabuladores();
    }

    /**
     * Este método verifica todas las sucursales existentes y agrega un tabulador
     * por todas y cada una de ellas para cliente
     */
    private function agregarTabuladores() {
        $sucursales = Sucursal::all(['id']);
        $nuevos_tabuladores = [];
        foreach ($sucursales as $sucursal) {
            array_push($nuevos_tabuladores, new Tabulador([
                'valor_original' => $this->valor_tabulador,
                'sucursal_id' => $sucursal->id
            ]));
        }
        $this->cliente->tabuladores()->saveMany($nuevos_tabuladores);
    }
}
