<?php

/**
 * @coversDefaultClass \App\TipoGarantia
 */
class TipoGarantiaTest extends TestCase
{
    protected $unidad;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $tg = factory(App\TipoGarantia::class)->make();
        $this->assertTrue($tg->isValid());
        $this->assertTrue($tg->save());
    }

    /**
     * @coversNothing
     */
    public function testSeriadoSoloPuedeSerBooleano()
    {
        $tg = factory(App\TipoGarantia::class)->make(['seriado' => 'NOVALIDO']);
        $this->assertFalse($tg->isValid());
        $this->assertFalse($tg->save());
    }

    /**
     * @coversNothing
     */
    public function testSeriadoCuandoNuloSeGuardaVerdadero()
    {
        $tg = factory(App\TipoGarantia::class)->make(['seriado' => '']);
        $this->assertTrue($tg->isValid());
        $this->assertTrue($tg->save());
        $this->assertSame(true, $tg->seriado);
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoPuedeSerNulo()
    {
        $tg = factory(App\TipoGarantia::class)->make(['descripcion' => '']);
        $this->assertFalse($tg->isValid());
        $this->assertFalse($tg->save());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoPuedeSerMuyLargo()
    {
        $tg = factory(App\TipoGarantia::class, 'longdesc')->make();
        $this->assertFalse($tg->isValid());
        $this->assertFalse($tg->save());
    }

    /**
     * @coversNothing
     */
    public function testDiasCuandoEsNuloGuardaCero()
    {
        $tg = factory(App\TipoGarantia::class)->make(['dias' => '']);
        $this->assertTrue($tg->isValid());
        $this->assertTrue($tg->save());
        $this->assertSame(0, $tg->dias);
    }

    /**
     * @coversNothing
     */
    public function testDiasNoPuedeSerNegativo()
    {
        $tg = factory(App\TipoGarantia::class)->make(['dias' => -1]);
        $this->assertFalse($tg->isValid());
    }

    /**
     * @covers ::productos
     */
    public function testProductos()
    {
        $tg = factory(App\TipoGarantia::class)->create();
        $producto = factory(App\Producto::class)->create([
            'tipo_garantia_id' => $tg->id
        ]);
        $testProducto = $tg->productos[0];
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
