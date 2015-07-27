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
     */
    public function testAtributosDeDimensionesSonRequeridos()
    {
        $dimension = factory(App\Dimension::class, 'emptyattr')->make();
        $this->assertFalse($dimension->isValid());
    }

    /**
     * @coversNothing
     */
    public function testAtributosNoPuedenSerNegativos()
    {
        $dimension = factory(App\Dimension::class, 'negativeattr')->make();
        $this->assertFalse($dimension->isValid());
    }

    /**
     * @covers ::producto
     */
    public function testProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $dimension = factory(App\Dimension::class)->create(['producto_id' => $producto->id]);
        $testProducto = $dimension->producto;
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
