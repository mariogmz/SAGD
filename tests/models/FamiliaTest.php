<?php

/**
 * @coversDefaultClass \App\Familia
 */
class FamiliaTest extends TestCase
{
    protected $familia;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $familia = factory(App\Familia::class)->make();
        $this->assertTrue($familia->isValid());
        $this->assertTrue($familia->save());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $familia = factory(App\Familia::class)->create();
        $familia->nombre = 'MC Hammer';
        $this->assertTrue($familia->isValid('update'));
        $this->assertTrue($familia->save());
        $this->assertSame('MC Hammer', $familia->nombre);
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeSerDuplicada()
    {
        $familia = factory(App\Familia::class)->create();
        $dup = clone $familia;
        $this->assertFalse($dup->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeSerNula()
    {
        $fam = factory(App\Familia::class)->make(['clave' => '']);
        $this->assertFalse($fam->isValid());
        $this->assertFalse($fam->save());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsMenorDeCuatroCaracteres()
    {
        $fam = factory(App\Familia::class)->make(['clave' => 'ABCDE']);
        $this->assertFalse($fam->isValid());
        $this->assertFalse($fam->save());
    }

    /**
     * @coversNothing
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
     * @coversNothing
     */
    public function testNombreNoPuedeSerNulo()
    {
        $fam = factory(App\Familia::class)->make(['nombre' => '']);
        $this->assertFalse($fam->isValid());
        $this->assertFalse($fam->save());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerMuyLargo()
    {
        $fam = factory(App\Familia::class, 'longname')->make();
        $this->assertFalse($fam->isValid());
        $this->assertFalse($fam->save());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionPuedeSerNulo()
    {
        $fam = factory(App\Familia::class)->make(['descripcion' => null]);
        $this->assertTrue($fam->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoPuedeSerMuyLargo()
    {
        $fam = factory(App\Familia::class, 'longdesc')->make();
        $this->assertFalse($fam->isValid());
    }

    /**
     * @covers ::subfamilias
     * @group relaciones
    */
    public function testSubfamilias()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $familia = $subfamilia->familia;
        $subfamilia = $familia->subfamilias[0];
        $this->assertInstanceOf(App\Subfamilia::class, $subfamilia);
    }
}
