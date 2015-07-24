<?php

/**
 * ProductoTest
 *
 * @group group
 */
class ProductoTest extends TestCase
{
    protected $producto;

    /**
     * @covers Producto::modeloEsValido()
     */
    public function testModeloEsValido()
    {
        $producto = factory(App\Producto::class)->make();
        $this->assertTrue($producto->isValid());
        $this->assertTrue($producto->save());
    }

    /**
     * @covers Producto::ActivoEsRequerido()
     */
    public function testActivoEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['activo' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::ActivoEsBooleano()
     */
    public function testActivoEsBooleano()
    {
        $producto = factory(App\Producto::class)->make(['activo' => 'A']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::claveEsRequerido()
     */
    public function testClaveEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['clave' => '']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::ClaveEsUnico()
     */
    public function testClaveEsUnico()
    {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make(['clave' => $producto->clave]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @covers Producto::claveEsMenorDe60Caracteres()
     */
    public function testClaveEsMenorDe60Caracteres()
    {
        $producto = factory(App\Producto::class, 'longclave')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::DescripcionEsRequerido()
     */
    public function testDescripcionEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['descripcion' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::DescripcionNoPuedeSerMayorA300Caracteres()
     */
    public function testDescripcionNoPuedeSerMayorA300Caracteres()
    {
        $producto = factory(App\Producto::class, 'longdescription')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::DescripcionCortaPuedeSerNulaPeroNoMayorA50Caracteres()
     */
    public function testDescripcionCortaNoEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['descripcion_corta' => null]);
        $this->assertTrue($producto->isValid());
    }

    /**
     * @covers Producto::DescripcionCortaNoPuedeSerMayorA50Caracteres()
     */
    public function testDescripcionCortaNoPuedeSerMayorA50Caracteres()
    {
        $producto = factory(App\Producto::class, 'longshortdesc')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::FechaEntradaEsRequerido()
     */
    public function testFechaEntradaEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['fecha_entrada' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::FechaEntradaEsValido()
     */
    public function testFechaEntradaEsValido()
    {
        $producto = factory(App\Producto::class)->make(['fecha_entrada' => 'asdasd']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::NumeroDeParteEsRequerido()
     */
    public function testNumeroDeParteEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['numero_parte' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::NumeroDeParteEsUnico()
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
     * @covers Producto::RemateEsRequerido()
     */
    public function testRemateEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['remate' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::RemateEsBooleano()
     */
    public function testRemateEsBooleano()
    {
        $producto = factory(App\Producto::class)->make(['remate' => 'A']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::SpiffEsRequerido()
     */
    public function testSpiffEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['spiff' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::SpiffEsDecimal()
     */
    public function testSpiffEsDecimal()
    {
        $producto = factory(App\Producto::class)->make(['spiff' => 'string']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::SubclaveEsRequerido()
     */
    public function testSubclaveEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['subclave' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::SubclaveSiesVacioTomaValorDeNumeroDeParte()
     */
    public function testSubclaveSiesVacioTomaValorDeNumeroDeParte()
    {
        $producto = factory(App\Producto::class)->make(['subclave' => null]);
        $this->assertTrue($producto->save());
        $this->assertSame($producto->numero_parte, $producto->subclave);
    }

    /**
     * @covers Producto::UpcEsRequerido()
     */
    public function testUpcEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['upc' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::UpcEsUnico()
     */
    public function testUpcEsUnico()
    {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make(['upc' => $producto->upc]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @covers Producto::UpcEsEntero()
     */
    public function testUpcEsEntero()
    {
        $producto = factory(App\Producto::class)->make(['upc' => 'string']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers Producto::tipoGarantia()
     */
    public function testTipoGarantia()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @covers Producto::marca()
     */
    public function testMarca()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @covers Producto::margen()
     */
    public function testMargen()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @covers Producto::unidad()
     */
    public function testUnidad()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @covers Producto::subfamilia()
     */
    public function testSubfamilia()
    {
        $this->markTestIncomplete('Not yet implemented');
    }
}
