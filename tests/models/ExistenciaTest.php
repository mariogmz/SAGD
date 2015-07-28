<?php

/**
* @coversDefaultClass \App\Existencia
*/
class ExistenciaTest extends TestCase
{
    protected $existencia;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $existencia = factory(App\Existencia::class)->make();
        $this->assertTrue($existencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadesNoPuedenSerNegativas()
    {
        $existencia = factory(App\Existencia::class, 'negativeamount')->make();
        $this->assertFalse($existencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadesTienenDefaultACero()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $ps = $producto->productosSucursales[0];
        $existencia = factory(App\Existencia::class, 'nullamount')->make([
            'productos_sucursales_id' => $ps->id]);
        $this->assertTrue($existencia->isValid());
        $existencia->save();
        $this->assertSame(0, $existencia->cantidad);
    }

    /**
     * @covers ::productoSucursal
     */
    public function testProductoSucursal()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $ps = $producto->productosSucursales[0];
        $existencia = factory(App\Existencia::class)->create([
            'productos_sucursales_id' => $ps->id]);
        $pss = $existencia->productoSucursal;
        $this->assertInstanceOf(App\ProductoSucursal::class, $pss);
    }
}
