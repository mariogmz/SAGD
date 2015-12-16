<?php

namespace App\Listeners;


use App\Events\ProductoCreado;
use App\Ficha;
use App\Producto;

class CrearFicha {

    protected $producto;

    /**
     * Create the event listener.
     * @param Producto $producto
     */
    public function __construct(Producto $producto) {
        $this->producto = $producto;
    }

    /**
     * Handle the event.
     *
     * @param  ProductoCreado $event
     * @return void
     */
    public function handle(ProductoCreado $event) {
        $this->producto = $event->producto;
        $this->crearFicha();
    }

    private function crearFicha() {
        $ficha = new Ficha();
        $ficha->producto()->associate($this->producto);
        $ficha->obtenerFichaDesdeIcecat();
    }
}
