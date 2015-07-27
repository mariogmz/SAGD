<?php

/**
 * @coversDefaultClass \App\Unidad
 */
class UnidadTest extends TestCase
{
    protected $unidad;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $unidad = factory(App\Unidad::class)->make();
        $this->assertTrue($unidad->isValid());
        $this->assertTrue($unidad->save());
    }

    /**
     * @coversNothing
     */
    public function testClaveVaciaNoEsValido()
    {
        $unidad = factory(App\Unidad::class)->make(['clave' => '']);
        $this->assertFalse($unidad->isValid());
        $this->assertFalse($unidad->save());
    }

    /**
     * @coversNothing
     */
    public function testNombreVacioNoEsValido()
    {
        $unidad = factory(App\Unidad::class)->make(['nombre' => '']);
        $this->assertFalse($unidad->isValid());
        $this->assertFalse($unidad->save());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeTenerMasDeCuatroDigitos()
    {
        $unidad = factory(App\Unidad::class)->make(['clave' => 'AAAAA']);
        $this->assertFalse($unidad->isValid());
        $this->assertFalse($unidad->save());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeTenerMasDe45Digitos()
    {
        $unidad = factory(App\Unidad::class, 'longname')->make();
        $this->assertFalse($unidad->isValid());
        $this->assertFalse($unidad->save());
    }

    /**
     * @coversNothing
     */
    public function testClaveDebeSerGuardadaEnMayusculas()
    {
        $unidad = factory(App\Unidad::class, 'lowercase')->make();
        $clave = strtoupper($unidad->clave);
        $this->assertTrue($unidad->save());
        $this->assertSame($clave, $unidad->clave);
    }

    /**
     * @covers ::productos
     */
    public function testProductos()
    {
        $unidad = factory(App\Unidad::class)->create();
        $producto = factory(App\Producto::class)->create(['unidad_id' => $unidad->id]);
        $testProducto = $unidad->productos[0];
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
