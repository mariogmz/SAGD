<?php

/**
 * @coversDefaultClass \App\Dimension
 */
class DimensionTest extends TestCase
{
    protected $dimension;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $dimension = factory(App\Dimension::class)->make();
        $this->assertTrue($dimension->isValid());
        $this->assertTrue($dimension->save());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $dimension = factory(App\Dimension::class)->create();
        $dimension->largo = 1991.0;
        $this->assertTrue($dimension->isValid('update'));
        $this->assertTrue($dimension->save());
        $this->assertSame(1991.0, $dimension->largo);
    }

    /**
     * @coversNothing
     */
    public function testAtributosDeDimensionesSonRequeridos()
    {
        $dimension = factory(App\Dimension::class, 'emptyattr')->make();
        $this->assertFalse($dimension->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLargoMayorQueCero() {
        $model = factory(App\Dimension::class)->make();
        $model->largo = 0;
        $this->assertFalse($model->isValid());
        $model->largo = 1;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testAnchoMayorQueCero() {
        $model = factory(App\Dimension::class)->make();
        $model->ancho = 0;
        $this->assertFalse($model->isValid());
        $model->ancho = 0.1;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testAltoMayorQueCero() {
        $model = factory(App\Dimension::class)->make();
        $model->alto = 0;
        $this->assertFalse($model->isValid());
        $model->alto = 0.1;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPesoMayorQueCero() {
        $model = factory(App\Dimension::class)->make();
        $model->peso = 0;
        $this->assertFalse($model->isValid());
        $model->peso = 0.1;
        $this->assertTrue($model->isValid());
    }


    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $dimension = factory(App\Dimension::class)->create(['producto_id' => $producto->id]);
        $testProducto = $dimension->producto;
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
