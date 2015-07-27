<?php

/**
 * SubfamiliaTest
 *
 * @group group
 */
class SubfamiliaTest extends TestCase
{
    protected $subfamilia;
    protected $familia;
    protected $margen;

    /**
     * @covers Subfamilia::ModeloEsValido()
     */
    public function testModeloEsValido()
    {
        $subfamilia = factory(App\Subfamilia::class)->make();
        $this->assertTrue($subfamilia->isValid());
        $this->assertTrue($subfamilia->save());
    }

    /**
     * @covers Subfamilia::ClaveNoPuedeSerNula()
     */
    public function testClaveNoPuedeSerNula()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['clave' => '']);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @covers Subfamilia::ClaveEsMenorDeCuatroCaracteres()
     */
    public function testClaveEsMenorDeCuatroCaracteres()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['clave' => 'AAAAA']);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @covers Subfamilia::ClaveEsSoloMayusculas()
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
     * @covers Subfamilia::NombreNoPuedeSerNulo()
     */
    public function testNombreNoPuedeSerNulo()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['nombre' => '']);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @covers Subfamilia::NombreNoPuedeTenerMasDe45Caracteres()
     */
    public function testNombreNoPuedeTenerMasDe45Caracteres()
    {
        $subfamilia = factory(App\Subfamilia::class, 'longname')->make();
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @covers Subfamilia::DebeTenerFamilia()
     */
    public function testDebeTenerFamilia()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['familia_id' => null]);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @covers Subfamilia::DebeTenerMargen()
     */
    public function testDebeTenerMargen()
    {
        $subfamilia = factory(App\Subfamilia::class)->make(['margen_id' => null]);
        $this->assertFalse($subfamilia->isValid());
    }

    /**
     * @covers Subfamilia::last()
     */
    public function testLast()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $this->assertSame($subfamilia->id, App\Subfamilia::last()->id);
    }

    /**
     * @covers Subfamilia::familia()
     */
    public function testFamilia()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $familia = $subfamilia->familia;
        $this->assertInstanceOf(App\Familia::class, $familia);
    }

    /**
     * @covers Subfamilia::Margen()
     */
    public function testMargen()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $margen = $subfamilia->margen;
        $this->assertInstanceOf(App\Margen::class, $margen);
    }

    /**
     * @covers Subfamilia::Productos()
     */
    public function testProductos()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $producto = factory(App\Producto::class)->create(['subfamilia_id' => $subfamilia->id]);
        $testProducto = $subfamilia->productos[0];
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
