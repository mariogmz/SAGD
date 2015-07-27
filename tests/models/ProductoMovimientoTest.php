<?php

/**
 * @coversDefaultClass \App\ProductoMovimiento
 */
class ProductoMovimientoTest extends TestCase
{
    protected $productoMovimiento;

    /**
     * @coversNothing
     * @expectedException PDOException
     */
    public function testModeloEsValido()
    {
        $pm = factory(App\ProductoMovimiento::class)->make();
        $this->assertTrue($pm->isValid());
        $this->assertFalse($pm->save());
    }

    /**
     * @coversNothing
     */
    public function testMovimientoEsRequerido()
    {
        $pm = factory(App\ProductoMovimiento::class)->make(['movimiento' => '']);
        $this->assertFalse($pm->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMovimientoNoPuedeTenerMasDe100Caracteres()
    {
        $pm = factory(App\ProductoMovimiento::class, 'longmovimiento')->make();
        $this->assertFalse($pm->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEntradasYSalidasCuandoSonNulasDefaultACero()
    {
        $pm = factory(App\ProductoMovimiento::class, 'nullES')->make();
        $this->assertTrue($pm->isValid());
        $producto = factory(App\Producto::class)->create();
        $pm['producto_id'] = $producto->id;
        $this->assertTrue($pm->save());
        $entraron = $pm->entraron;
        $salieron = $pm->salieron;
        $this->assertSame(0, $entraron);
        $this->assertSame(0, $salieron);
    }

    /**
     * @coversNothing
     */
    public function testExistenciasSonDefaultACero()
    {
        $pm = factory(App\ProductoMovimiento::class, 'nullEX')->make();
        $this->assertTrue($pm->isValid());
        $producto = factory(App\Producto::class)->create();
        $pm['producto_id'] = $producto->id;
        $this->assertTrue($pm->save());
        $exAntes = $pm->existencias_antes;
        $exDespues = $pm->existencias_despues;
        $this->assertSame(0, $exAntes);
        $this->assertSame(0, $exDespues);
    }

    /**
     * @coversNothing
     */
    public function testExistenciasYEntradasSalidasNoPuedenSerNegativas()
    {
        $pm = factory(App\ProductoMovimiento::class, 'negative')->make();
        $this->assertFalse($pm->isValid());
    }

    /**
     * @covers ::producto
     */
    public function testProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $pm = factory(App\ProductoMovimiento::class, 'withproduct')->create(['producto_id' => $producto->id]);
        $testProducto = $pm->producto;
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
