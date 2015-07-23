<?php


class FamiliaTest extends TestCase
{
    protected $familia;

    /**
     * @covers Margen::()
     */
    public function testModeloEsValido()
    {
        $familia = factory(App\Familia::class)->make();
        $this->assertTrue($familia->isValid());
        $this->assertTrue($familia->save());
    }

    /**
     * @covers Familia::ClaveNoPuedeSerNula()
     */
    public function testClaveNoPuedeSerNula()
    {
        $fam = factory(App\Familia::class)->make(['clave' => '']);
        $this->assertFalse($fam->isValid());
        $this->assertFalse($fam->save());
    }

    /**
     * @covers Familia::ClaveSoloEsDeCuatroCaracteres()
     */
    public function testClaveEsMenorDeCuatroCaracteres()
    {
        $fam = factory(App\Familia::class)->make(['clave' => 'ABCDE']);
        $this->assertFalse($fam->isValid());
        $this->assertFalse($fam->save());
    }

    /**
     * @covers Familia::ClaveEsSoloMayusculas()
     */
    public function testClaveEsSoloMayusculas()
    {
        $fam = factory(App\Familia::class, 'minclave')->make();
        $clave = strtoupper($fam->clave);
        $this->assertTrue($fam->isValid());
        $this->assertTrue($fam->save());
        $this->assertSame($clave, $fam->clave);
    }

    /**
     * @covers Familia::NombreNoPuedeSerNulo()
     */
    public function testNombreNoPuedeSerNulo()
    {
        $fam = factory(App\Familia::class)->make(['nombre' => '']);
        $this->assertFalse($fam->isValid());
        $this->assertFalse($fam->save());
    }

    /**
     * @covers Familia::NombreNoPuedeSerMuyLargo()
     */
    public function testNombreNoPuedeSerMuyLargo()
    {
        $fam = factory(App\Familia::class, 'longname')->make();
        $this->assertFalse($fam->isValid());
        $this->assertFalse($fam->save());
    }

    /**
     * @covers Familia::DescripcionPuedeSerNulo()
     */
    public function testDescripcionPuedeSerNulo()
    {
        $fam = factory(App\Familia::class)->make(['descripcion' => null]);
        $this->assertTrue($fam->isValid());
    }

    /**
     * @covers Familia::DescripcionNoPuedeSerMuyLargo()
     */
    public function testDescripcionNoPuedeSerMuyLargo()
    {
        $fam = factory(App\Familia::class, 'longdesc')->make();
        $this->assertFalse($fam->isValid());
    }
}
