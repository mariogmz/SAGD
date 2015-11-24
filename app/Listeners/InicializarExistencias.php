<?php

namespace App\Listeners;

use App\Events\ProductoCreado;
use App\Existencia;
use App\Producto;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InicializarExistencias
{
    protected $producto;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    /**
     * Handle the event.
     *
     * @param  ProductoCreado  $event
     * @return void
     */
    public function handle(ProductoCreado $event)
    {
        $this->producto = $event->producto;
        $this->inicializarExistencias();
    }

    private function inicializarExistencias() {
        $this->producto->productosSucursales->each(function ($productoSucursal) {
            $productoSucursal->existencia()->save(new Existencia);
        });
    }
}
