<?php

namespace App\Listeners;

use App\Events\ProductoCreado;
use App\Producto;
use App\Sucursal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AttachSucursales
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
        $this->attachSucursales();
    }

    private function attachSucursales() {
        $sucursales = Sucursal::all();
        foreach ($sucursales as $sucursal) {
            $this->producto->addSucursal($sucursal);
        }
    }
}
