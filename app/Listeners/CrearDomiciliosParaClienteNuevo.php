<?php

namespace App\Listeners;


use App\Cliente;
use App\CodigoPostal;
use App\Domicilio;
use App\Events\ClienteCreado;
use App\Telefono;

class CrearDomiciliosParaClienteNuevo {

    protected $cliente;
    protected $datos;

    /**
     * Create the event listener.
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
        $this->datos = $event->datos;
        $this->agregarDomicilios();
    }

    /**
     * Este método verifica los datos domiciliarios y teléfonicos proporcionados
     * y los asocia al cliente
     */
    private function agregarDomicilios() {
        if (!empty($this->datos['domicilio'])) {
            $datos_domicilio = $this->datos['domicilio'];
            $codigo_postal = CodigoPostal::where('codigo_postal',$datos_domicilio['codigo_postal']['codigo_postal'])->first();
            if(!empty($codigo_postal)){
                // Guarda domicilio
                $domicilio = new Domicilio([
                    'calle' => $datos_domicilio['calle'],
                    'localidad' => $datos_domicilio['localidad'],
                ]);

                // Asocia el codigo postal al nuevo domicilio
                $domicilio->codigoPostal()->associate($codigo_postal);
                // Guardar el domicilio
                $domicilio->save();

                // Asociar un nuevo teléfono al domicilio
                $telefono = new Telefono();
                $telefono->fill($datos_domicilio['telefono']);
                $domicilio->telefonos()->save($telefono);

                // Asociar el domicilio al cliente
                $this->cliente->domicilios()->attach($domicilio->id);
            }

        }
    }
}
