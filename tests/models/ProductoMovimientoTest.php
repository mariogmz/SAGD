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
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $producto = factory(App\Producto::class)->create();
        $pm = factory(App\ProductoMovimiento::class, 'withproduct')->create(['producto_id' => $producto->id]);
        $pm->movimiento = 'MC Hammer';
        $this->assertTrue($pm->isValid('update'));
        $this->assertTrue($pm->save());
        $this->assertSame('MC Hammer', $pm->movimiento);
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
     * @group relaciones
     */
    public function testProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $pm = factory(App\ProductoMovimiento::class, 'withproduct')->create(['producto_id' => $producto->id]);
        $testProducto = $pm->producto;
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }

    /**
     * @covers ::rmaDetalles
     * @group relaciones
     */
    public function testRmaDetalles() {
        $parent = factory(App\ProductoMovimiento::class, 'withproduct')->create();
        factory(App\RmaDetalle::class)->create([
            'producto_movimiento_id' => $parent->id
        ]);
        $children = $parent->rmaDetalles;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\RmaDetalle', $children[0]);
        $this->assertCount(1, $children);
    }


    /**
     * @covers ::entradasDetalles
     * @group relaciones
     */
    public function testEntradasDetalles()
    {
        $pm = factory(App\ProductoMovimiento::class, 'withproduct')->create();
        $ed = factory(App\EntradaDetalle::class, 'full')->create(['producto_movimiento_id' => $pm->id]);
        $eds = $pm->entradasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $eds);
        $this->assertInstanceOf(App\EntradaDetalle::class, $eds[0]);
        $this->assertCount(1, $eds);
    }

    /**
     * @covers ::salidasDetalles
     * @group relaciones
     */
    public function testSalidasDetalles()
    {
        $pm = factory(App\ProductoMovimiento::class, 'withproduct')->create();
        $sd = factory(App\SalidaDetalle::class, 'full')->create(['producto_movimiento_id' => $pm->id]);
        $sds = $pm->salidasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $sds);
        $this->assertInstanceOf(App\SalidaDetalle::class, $sds[0]);
        $this->assertCount(1, $sds);
    }

    /**
     * @covers ::transferenciasDetalles
     * @group relaciones
     */
    public function testTransferenciasDetalles()
    {
        $pm = factory(App\ProductoMovimiento::class, 'withproduct')->create();
        $td = factory(App\TransferenciaDetalle::class, 'full')->create([
            'producto_movimiento_id' => $pm->id]);
        $tds = $pm->transferenciasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $tds);
        $this->assertInstanceOf(App\TransferenciaDetalle::class, $tds[0]);
        $this->assertCount(1, $tds);
    }

    /**
     * @covers ::apartadosDetalles
     * @group relaciones
     */
    public function testApartadosDetalles()
    {
        $pm = factory(App\ProductoMovimiento::class, 'withproduct')->create();
        $ad = factory(App\ApartadoDetalle::class, 'full')->create([
            'producto_id' => $pm->producto->id,
            'producto_movimiento_id' => $pm->id]);
        $ads = $pm->apartadosDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $ads);
        $this->assertInstanceOf(App\ApartadoDetalle::class, $ads[0]);
        $this->assertCount(1, $ads);
    }
}
