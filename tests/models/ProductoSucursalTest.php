<?php

/**
* @coversDefaultClass \App\ProductoSucursal
*/
class ProductoSucursalTest extends TestCase
{

    protected $productoSucursal;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $ps = factory(App\ProductoSucursal::class)->make();
        $this->assertTrue($ps->isValid());
    }

    /**
     * @covers ::existencias
     * @group relaciones
     */
    public function testExistencias()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $ps = $producto->productosSucursales[0];
        $existencia = factory(App\Existencia::class)->make();
        $existencia->productoSucursal()->associate($ps)->save();
        $existencias = $ps->existencias;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class,
            $existencias);
        $this->assertInstanceOf(App\Existencia::class, $existencias[0]);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $ps = $producto->productosSucursales->last();
        $sucursal = $ps->sucursal;
        $this->assertInstanceOf(App\Sucursal::class, $sucursal);
    }

    /**
     * @covers ::precio
     * @group relaciones
     */
    public function testPrecio()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $precio = $producto->productosSucursales[0]->precio;
        $this->assertInstanceOf(App\Precio::class, $precio);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $ps = $producto->productosSucursales[0];
        $testProducto = $ps->producto;
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
