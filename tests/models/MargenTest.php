<?php

/**
 * @coversDefaultClass \App\Margen
 */
class MargenTest extends TestCase
{
    protected $margen;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $margen = factory(App\Margen::class)->make();
        $this->assertTrue($margen->isValid());
        $this->assertTrue($margen->save());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $margen = factory(App\Margen::class)->create();
        $margen->nombre = 'MC Hammer';
        $this->assertTrue($margen->isValid('update'));
        $this->assertTrue($margen->save());
        $this->assertSame('MC Hammer', $margen->nombre);
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerNulo()
    {
        $margen = factory(App\Margen::class)->make(['nombre' => '']);
        $this->assertFalse($margen->isValid());
        $this->assertFalse($margen->save());
    }

    /**
     * @coversNothing
     */
    public function testValorEsRequerido() {
        $model = factory(App\Margen::class)->make([
            'valor' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorWebserviceP1EsRequerido() {
        $model = factory(App\Margen::class)->make([
            'valor_webservice_p1' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorWebserviceP8EsRequerido() {
        $model = factory(App\Margen::class)->make([
            'valor_webservice_p8' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerMuyLargo()
    {
        $margen = factory(App\Margen::class, 'longname')->make();
        $this->assertFalse($margen->isValid());
        $this->assertFalse($margen->save());
    }

    /**
     * @coversNothing
     */
    public function testDecimalesNoPuedenSerNegativos()
    {
        $margen = factory(App\Margen::class, 'negativedecimals')->make();
        $this->assertFalse($margen->isValid());
        $this->assertFalse($margen->save());
    }

    /**
     * @coversNothing
     */
    public function testDecimalesNoPuedenSerMayorAUno()
    {
        $margen = factory(App\Margen::class, 'overonedecimal')->make();
        $this->assertFalse($margen->isValid());
        $this->assertFalse($margen->save());
    }


    /**
     * @covers ::subfamilias
     * @group relaciones
     */
    public function testSubfamilias()
    {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $margen = $subfamilia->margen;
        $subfamilia = $margen->subfamilias[0];
        $this->assertInstanceOf(App\Subfamilia::class, $subfamilia);
    }

    /**
     * @covers ::productos
     * @group relaciones
     */
    public function testProductos()
    {
        $margen = factory(App\Margen::class)->create();
        $producto = factory(App\Producto::class)->create(['margen_id' => $margen->id]);
        $testProducto = $margen->productos[0];
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
