<?php


class UnidadTest extends TestCase
{
    protected $unidad;

    /**
     * @covers Unidad::()
     */
    public function testModeloEsValido()
    {
        $unidad = factory(App\Unidad::class)->make();
        $this->assertTrue($unidad->isValid());
        $this->assertTrue($unidad->save());
    }

    /**
     * @covers Unidad::()
     */
    public function testClaveVaciaNoEsValido()
    {
        $unidad = factory(App\Unidad::class)->make(['clave' => '']);
        $this->assertFalse($unidad->isValid());
        $this->assertFalse($unidad->save());
    }

    /**
     * @covers Unidad::()
     */
    public function testNombreVacioNoEsValido()
    {
        $unidad = factory(App\Unidad::class)->make(['nombre' => '']);
        $this->assertFalse($unidad->isValid());
        $this->assertFalse($unidad->save());
    }

    /**
     * @covers Unidad::()
     */
    public function testClaveNoPuedeTenerMasDeCuatroDigitos()
    {
        $unidad = factory(App\Unidad::class)->make(['clave' => 'AAAAA']);
        $this->assertFalse($unidad->isValid());
        $this->assertFalse($unidad->save());
    }

    /**
     * @covers Unidad::()
     */
    public function testNombreNoPuedeTenerMasDe45Digitos()
    {
        $unidad = factory(App\Unidad::class, 'longname')->make();
        $this->assertFalse($unidad->isValid());
        $this->assertFalse($unidad->save());
    }

    /**
     * @covers Unidad::()
     */
    public function testClaveDebeSerGuardadaEnMayusculas()
    {
        $unidad = factory(App\Unidad::class, 'lowercase')->make();
        $clave = strtoupper($unidad->clave);
        $this->assertTrue($unidad->save());
        $this->assertSame($clave, $unidad->clave);
    }
}
