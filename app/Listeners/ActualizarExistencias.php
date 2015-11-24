<?php

namespace App\Listeners;

use App\Events\CreandoProductoMovimiento;
use App\Existencia;
use App\ProductoMovimiento;
use App\ProductoSucursal;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActualizarExistencias
{

    protected $productoMovimiento;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        Existencia $existencia, ProductoMovimiento $productoMovimiento,
        ProductoSucursal $productoSucursal)
    {
        $this->existencia = $existencia;
        $this->productoMovimiento = $productoMovimiento;
        $this->productoSucursal = $productoSucursal;
    }

    /**
     * Handle the event.
     *
     * @param  CreandoProductoMovimiento  $event
     * @return array
     */
    public function handle(CreandoProductoMovimiento $event)
    {
        $this->productoMovimiento = $event->productoMovimiento;
        $this->productoSucursal = $this->productoMovimiento->productoSucursal;
        $this->existencia = $this->productoSucursal->existencia;

        $existancias_antes = $this->existencia->cantidad;
        $this->existencia->cantidad += $this->productoMovimiento->entraron;
        $this->existencia->cantidad -= $this->productoMovimiento->salieron;
        $existancias_despues = $this->existencia->cantidad;

        if( $this->existencia->save() ) {
            return [
                'success' => true,
                'antes' => $existancias_antes,
                'despues' => $existancias_despues
            ];
        } else {
            return ['success' => false];
        }
    }
}
