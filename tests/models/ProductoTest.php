<?php

/**
 * @coversDefaultClass \App\Producto
 */
class ProductoTest extends TestCase
{
    protected $producto;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $producto = factory(App\Producto::class)->make();
        $this->assertTrue($producto->isValid());
        $this->assertTrue($producto->save());
    }

    /**
     * @coversNothing
     */
    public function testActivoEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['activo' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testActivoEsBooleano()
    {
        $producto = factory(App\Producto::class)->make(['activo' => 'A']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['clave' => '']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnico()
    {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make(['clave' => $producto->clave]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsMenorDe60Caracteres()
    {
        $producto = factory(App\Producto::class, 'longclave')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['descripcion' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoPuedeSerMayorA300Caracteres()
    {
        $producto = factory(App\Producto::class, 'longdescription')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionCortaNoEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['descripcion_corta' => null]);
        $this->assertTrue($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionCortaNoPuedeSerMayorA50Caracteres()
    {
        $producto = factory(App\Producto::class, 'longshortdesc')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaEntradaEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['fecha_entrada' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaEntradaEsValido()
    {
        $producto = factory(App\Producto::class)->make(['fecha_entrada' => 'asdasd']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['numero_parte' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteEsUnico()
    {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make([
            'numero_parte' => $producto->numero_parte
        ]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRemateEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['remate' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRemateEsBooleano()
    {
        $producto = factory(App\Producto::class)->make(['remate' => 'A']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSpiffEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['spiff' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSpiffEsDecimal()
    {
        $producto = factory(App\Producto::class)->make(['spiff' => 'string']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSubclaveEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['subclave' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers ::boot
     */
    public function testSubclaveSiesVacioTomaValorDeNumeroDeParte()
    {
        $producto = factory(App\Producto::class)->make(['subclave' => null]);
        $this->assertTrue($producto->save());
        $this->assertSame($producto->numero_parte, $producto->subclave);
    }

    /**
     * @coversNothing
     */
    public function testUpcEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['upc' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUpcEsUnico()
    {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make(['upc' => $producto->upc]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUpcEsEntero()
    {
        $producto = factory(App\Producto::class)->make(['upc' => 'string']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers ::tipoGarantia
     */
    public function testTipoGarantia()
    {
        $producto = factory(App\Producto::class)->make();
        $tipoGarantia = $producto->tipoGarantia;
        $this->assertInstanceOf(App\TipoGarantia::class, $tipoGarantia);
    }

    /**
     * @covers ::marca
     */
    public function testMarca()
    {
        $producto = factory(App\Producto::class)->make();
        $marca = $producto->marca;
        $this->assertInstanceOf(App\Marca::class, $marca);
    }

    /**
     * @covers ::margen
     */
    public function testMargen()
    {
        $producto = factory(App\Producto::class, 'withmargen')->make();
        $margen = $producto->margen;
        $this->assertInstanceOf(App\Margen::class, $margen);
    }

    /**
     * @covers ::unidad
     */
    public function testUnidad()
    {
        $producto = factory(App\Producto::class)->make();
        $unidad = $producto->unidad;
        $this->assertInstanceOf(App\Unidad::class, $unidad);
    }

    /**
     * @covers ::subfamilia
     */
    public function testSubfamilia()
    {
        $producto = factory(App\Producto::class)->make();
        $subfamilia = $producto->subfamilia;
        $this->assertInstanceOf(App\Subfamilia::class, $subfamilia);
    }

    /**
     * @covers class::dimension()
     */
    public function testDimension()
    {
        $producto = factory(App\Producto::class)->create();
        $dimension = factory(App\Dimension::class)->create(['producto_id' => $producto->id]);
        $testDimension = $producto->dimension;
        $this->assertInstanceOf(App\Dimension::class, $testDimension);
    }
}
