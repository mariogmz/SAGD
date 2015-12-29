<?php

namespace App\Listeners;


use App\Cliente;
use App\Events\SucursalNueva;
use App\Sucursal;
use App\Tabulador;

class CrearTabuladoresParaSucursalNueva {

    protected $sucursal;

    /**
     * Create the event listener.
     * @param Sucursal $sucursal
     */
    public function __construct(Sucursal $sucursal) {
        $this->sucursal = $sucursal;
    }

    /**
     * Handle the event.
     *
     * @param  SucursalNueva $event
     * @return void
     */
    public function handle(SucursalNueva $event) {
        $this->sucursal = $event->sucursal;
        $this->agregarTabuladores();
    }

    private function agregarTabuladores() {
        $clientes = Cliente::all(['id', 'sucursal_id']);
        $nuevos_tabuladores = [];

        foreach ($clientes as $cliente) {
            // Se busca el valor del tabulador para la sucursal predeterminada del cliente
            // y se usa como base para crear el tabulador para la nueva sucursal
            $tabulador_base = $cliente->tabuladores()
                ->where('sucursal_id', $cliente->sucursal_id)
                ->first(['cliente_id','valor', 'valor_original']);
            $tabulador_base = $tabulador_base? $tabulador_base->toArray(): ['cliente_id' => $cliente->id];
            array_push($nuevos_tabuladores, new Tabulador($tabulador_base));
        }
        $this->sucursal->tabuladores()->saveMany($nuevos_tabuladores);
    }
}
