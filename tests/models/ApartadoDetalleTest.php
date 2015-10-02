<?php

/**
 * @coversDefaultClass \App\ApartadoDetalle
 */
class ApartadoDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $ad = factory(App\ApartadoDetalle::class)->make();
        $this->assertTrue($ad->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $ad = factory(App\ApartadoDetalle::class, 'full')->create();
        $ad->cantidad = 1991;
        $this->assertTrue($ad->isValid('update'));
        $this->assertTrue($ad->save());
        $this->assertSame(1991, $ad->cantidad);
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsObligatorio()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['cantidad' => null]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsEntero()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['cantidad' => 10.2]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsPositivo()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['cantidad' => -1]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaAntesEsObligatorio()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['existencia_antes' => null]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaAntesEsEntero()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['existencia_antes' => 10.2]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaAntesEsPositivo()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['existencia_antes' => -1]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDespuesEsObligatorio()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['existencia_despues' => null]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDespuesEsEntero()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['existencia_despues' => 10.2]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDespuesEsPositivo()
    {
        $ad = factory(App\ApartadoDetalle::class)->make(['existencia_despues' => -1]);
        $this->assertFalse($ad->isValid());
    }

    /**
     * @covers ::apartado
     * @group relaciones
     */
    public function testApartado()
    {
        $ad = factory(App\ApartadoDetalle::class, 'full')->make();
        $apartado = $ad->apartado;
        $this->assertInstanceOf(App\Apartado::class, $apartado);
    }

    /**
     * @covers ::apartado
     * @group relaciones
     */
    public function testApartadoAssociate()
    {
        $ad = factory(App\ApartadoDetalle::class, 'full')->make(['apartado_id' => null]);
        $apartado = factory(App\Apartado::class, 'full')->create();
        $ad->apartado()->associate($apartado);
        $this->assertInstanceOf(App\Apartado::class, $ad->apartado);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $ad = factory(App\ApartadoDetalle::class, 'full')->make();
        $producto = $ad->producto;
        $this->assertInstanceOf(App\Producto::class, $producto);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProductoAssociate()
    {
        $ad = factory(App\ApartadoDetalle::class, 'full')->make(['producto_id' => null]);
        $producto = factory(App\Producto::class)->create();
        $ad->producto()->associate($producto);
        $this->assertInstanceOf(App\Producto::class, $ad->producto);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimiento()
    {
        $ad = factory(App\ApartadoDetalle::class, 'full')->make();
        $pm = $ad->productoMovimiento;
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pm);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimientoAssociate()
    {
        $ad = factory(App\ApartadoDetalle::class, 'full')->make(['producto_movimiento_id' => null]);
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $ad->productoMovimiento()->associate($pm);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $ad->productoMovimiento);
    }
}
