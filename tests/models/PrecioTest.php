<?php

/**
* @coversDefaultClass \App\Precio
*/
class PrecioTest extends TestCase
{
    protected $precio;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $precio = factory(App\Precio::class)->make();
        $this->assertTrue($precio->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $precio->costo = 1991.0;
        $this->assertTrue($precio->isValid('update'));
        $this->assertTrue($precio->save());
        $this->assertSame(1991.0, $precio->costo);
    }

    /**
     * @coversNothing
     */
    public function testCostoEsRequerido()
    {
        $precio = factory(App\Precio::class, 'nullcosto')->make();
        $this->assertFalse($precio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoNoPuedeSerNegativo()
    {
        $precio = factory(App\Precio::class, 'negcosto')->make();
        $this->assertFalse($precio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPreciosSonRequeridos()
    {
        $precio = factory(App\Precio::class, 'nullprecios')->make();
        $this->assertFalse($precio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPreciosNoPuedenSerNegativos()
    {
        $precio = factory(App\Precio::class, 'negprecios')->make();
        $this->assertFalse($precio->isValid());
    }

    /**
     * @covers ::productoSucursal
     * @group relaciones
     */
    public function testProductoSucursal()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $ps = $precio->productoSucursal;
        $this->assertInstanceOf(App\ProductoSucursal::class, $ps);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $testProducto = $precio->producto;
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
