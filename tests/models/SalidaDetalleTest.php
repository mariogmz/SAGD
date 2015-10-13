<?php

/**
 * @coversDefaultClass \App\SalidaDetalle
 */
class SalidaDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $sd = factory(App\SalidaDetalle::class)->make();
        $this->assertTrue($sd->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $sd = factory(App\SalidaDetalle::class, 'full')->create();
        $sd->cantidad = 1991;
        $this->assertTrue($sd->isValid('update'));
        $this->assertTrue($sd->save());
        $this->assertSame(1991, $sd->cantidad);
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsObligatorio()
    {
        $sd = factory(App\SalidaDetalle::class)->make(['cantidad' => null]);
        $this->assertFalse($sd->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadTieneQueSerEntero()
    {
        $sd = factory(App\SalidaDetalle::class)->make(['cantidad' => 1991.5]);
        $this->assertFalse($sd->isValid());
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $sd = factory(App\SalidaDetalle::class, 'full')->make();
        $producto = $sd->producto;
        $this->assertInstanceOf(App\Producto::class, $producto);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProductoAssociate()
    {
        $sd = factory(App\SalidaDetalle::class, 'noproducto')->make();
        $producto = factory(App\Producto::class)->create();
        $sd->producto()->associate($producto);
        $this->assertInstanceOf(App\Producto::class, $sd->producto);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimiento()
    {
        $sd = factory(App\SalidaDetalle::class, 'full')->make();
        $pm = $sd->productoMovimiento;
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pm);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimientoAssociate()
    {
        $sd = factory(App\SalidaDetalle::class, 'noproductomovimiento')->make();
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $sd->productoMovimiento()->associate($pm);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $sd->productoMovimiento);
    }

    /**
     * @covers ::salida
     * @group relaciones
     */
    public function testSalida()
    {
        $sd = factory(App\SalidaDetalle::class, 'full')->make();
        $salida = $sd->salida;
        $this->assertInstanceOf(App\Salida::class, $salida);
    }

    /**
     * @covers ::salida
     * @group relaciones
     */
    public function testSalidaAssociate()
    {
        $sd = factory(App\SalidaDetalle::class, 'nosalida')->make();
        $salida = factory(App\Salida::class, 'full')->create();
        $sd->salida()->associate($salida);
        $this->assertInstanceOf(App\Salida::class, $sd->salida);
    }
}
