<?php

/**
 * @coversDefaultClass \App\Subfamilia
 */
class SubfamiliaTest extends TestCase
{
    protected $subfamilia;
    protected $familia;
    protected $margen;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $subfamilia = factory(App\Subfamilia::class)->make();
        $this->assertTrue($subfamilia->isValid());
        $this->assertTrue($subfamilia->save());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $subfamilia->nombre = 'MC Hammer';
        $this->assertTrue($subfamilia->isValid('update'));
        $this->assertTrue($subfamilia->save());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeSerDuplicada()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $dup = clone $subfamilia;
        $this->assertFalse($dup->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeSerNula()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['clave' => '']);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsMenorDeCuatroCaracteres()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['clave' => 'AAAAA']);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsSoloMayusculas()
    {
        $subfamilia = factory(App\Subfamilia::class, 'lowerclave')->make();
        $clave = strtoupper($subfamilia->clave);
        $this->assertTrue($subfamilia->isValid());
        $this->assertTrue($subfamilia->save());
        $this->assertSame($clave, $subfamilia->clave);
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerNulo()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['nombre' => '']);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeTenerMasDe45Caracteres()
    {
        $subfamilia = factory(App\Subfamilia::class, 'longname')->make();
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDebeTenerFamilia()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['familia_id' => null]);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDebeTenerMargen()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['margen_id' => null]);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLast()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $this->assertSame($subfamilia->id, App\Subfamilia::last()->id);
    }

    /**
     * @covers ::familia
     */
    public function testFamilia()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $familia = $subfamilia->familia;
        $this->assertInstanceOf(App\Familia::class, $familia);
    }

    /**
     * @covers ::margen
     */
    public function testMargen()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $margen = $subfamilia->margen;
        $this->assertInstanceOf(App\Margen::class, $margen);
    }

    /**
     * @covers ::productos
     */
    public function testProductos()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $producto = factory(App\Producto::class)->create(['subfamilia_id' => $subfamilia->id]);
        $testProducto = $subfamilia->productos[0];
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
