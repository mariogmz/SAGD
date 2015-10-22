<?php

namespace App\Listeners;

use App\Events\SucursalNueva;
use App\Events\SucursalCreada;
use App\Precio;
use App\Producto;
use App\Sucursal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sagd\SafeTransactions;

class CrearPreciosParaSucursalNueva implements ShouldQueue
{
    use SafeTransactions, SerializesModels;

    protected $sucursal;
    protected $base;
    protected $producto;
    protected $precio;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  SucursalNueva  $event
     * @return void
     */
    public function handle(SucursalNueva $event)
    {
        $this->sucursal = $event->sucursal;
        $this->base = $event->base;

        $jobStatus = $this->guardar();

        event(new SucursalCreada($this->sucursal->clave, $jobStatus));
    }

    /**
     * @return bool
     */
    private function guardar()
    {
        $base = $this->base;
        $lambda = function () use ($base) {
            $sucursal_base = Sucursal::find($base);
            return $this->asignarPrecios($sucursal_base);
        };
        if ($this->safe_transaction($lambda) ) {
            return true;
        } else {
            // We should probably delete the Sucursal since it's not in the
            // transaction. ForceDelete to bypass the soft delete.
            $this->sucursal->forceDelete();
            return false;
        }
    }

    /**
     * @param Sucursal $sucursal
     * @return bool
     */
    public function asignarPrecios(Sucursal $sucursal)
    {
        $productos = $this->obtenerProductosAsociadosConSucursal($sucursal);
        foreach ($productos as $producto) {
            $producto->addSucursal($this->sucursal);
            $precio = $this->generarNuevoPrecio($producto, $sucursal);
            if ( $this->agregarPrecioParaProducto($producto, $precio) ) {
                continue;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Sucursal $sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function obtenerProductosAsociadosConSucursal(Sucursal $sucursal)
    {
        return Producto::whereHas('productosSucursales', function($query) use ($sucursal) {
            $query->where('sucursal_id', $sucursal->id);
        })->get();
    }

    /**
     * @param Producto $producto
     * @param Sucursal $sucursal
     * @return Precio
     */
    private function generarNuevoPrecio(Producto $producto, Sucursal $sucursal)
    {
        $columns = ['costo' => 0, 'precio_1' => 0, 'precio_2' => 0, 'precio_3' => 0, 'precio_4' => 0, 'precio_5' => 0, 'precio_6' => 0, 'precio_7' => 0, 'precio_8' => 0, 'precio_9' => 0, 'precio_10' => 0];
        $precio_base = $producto->precios()->where('sucursal_id', $sucursal->id)->first()->toArray();
        $values = array_intersect_key($precio_base, $columns);
        return new Precio($values);
    }

    /**
     * @param Producto $producto
     * @param Precio $precio
     * @return bool
     */
    private function agregarPrecioParaProducto(Producto $producto, Precio $precio)
    {
        $producto_sucursal = $producto->productosSucursales()->where('sucursal_id', $this->sucursal->id)->first();
        if ( $precio->productoSucursal()->associate($producto_sucursal)->save() ) {
            return true;
        } else {
            return false;
        }
    }
}
