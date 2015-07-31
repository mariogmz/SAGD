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
     */
    public function testRmaDetalles(){
        $producto_movimiento = factory(App\ProductoMovimiento::class, 'withproduct')->create();
        factory(App\RmaDetalle::class, 5)->create([
            'rma_id' => $producto_movimiento->id
        ]);
        $rmas_detalles = App\ProductoMovimiento::find($producto_movimiento->id)->rmaDetalles;
        foreach($rmas_detalles as $rd){
            $this->assertInstanceOf('App\RmaDetalle', $rd);
            $this->assertEquals($producto_movimiento->id, $rd->rma_id);
        }
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
}
