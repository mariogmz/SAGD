<?php


class TipoGarantiaTest extends TestCase
{
    protected $unidad;

    /**
     * @covers TipoGarantia::()
     */
    public function testModeloEsValido()
    {
        $tg = factory(App\TipoGarantia::class)->make();
        $this->assertTrue($tg->isValid());
        $this->assertTrue($tg->save());
    }

    /**
     * @covers TipoGarantia::SeriadoSoloPuedeSerBooleano()
     */
    public function testSeriadoSoloPuedeSerBooleano()
    {
        $tg = factory(App\TipoGarantia::class)->make(['seriado' => 'NOVALIDO']);
        $this->assertFalse($tg->isValid());
        $this->assertFalse($tg->save());
    }

    /**
     * @covers TipoGarantia::SeriadoCuandoNuloSeGuardaVerdadero()
     */
    public function testSeriadoCuandoNuloSeGuardaVerdadero()
    {
        $tg = factory(App\TipoGarantia::class)->make(['seriado' => '']);
        $this->assertTrue($tg->isValid());
        $this->assertTrue($tg->save());
        $this->assertSame(true, $tg->seriado);
    }

    /**
     * @covers TipoGarantia::DescripcionNoPuedeSerNulo()
     */
    public function testDescripcionNoPuedeSerNulo()
    {
        $tg = factory(App\TipoGarantia::class)->make(['descripcion' => '']);
        $this->assertFalse($tg->isValid());
        $this->assertFalse($tg->save());
    }

    /**
     * @covers TipoGarantia::DescripcionNoPuedeSerMuyLargo()
     */
    public function testDescripcionNoPuedeSerMuyLargo()
    {
        $tg = factory(App\TipoGarantia::class, 'longdesc')->make();
        $this->assertFalse($tg->isValid());
        $this->assertFalse($tg->save());
    }

    /**
     * @covers TipoGarantia::DiasCuandoEsNuloGuardaCero()
     */
    public function testDiasCuandoEsNuloGuardaCero()
    {
        $tg = factory(App\TipoGarantia::class)->make(['dias' => '']);
        $this->assertTrue($tg->isValid());
        $this->assertTrue($tg->save());
        $this->assertSame(0, $tg->dias);
    }

    /**
     * @covers TipoGarantia::DiasNoPuedeSerNegativo()
     */
    public function testDiasNoPuedeSerNegativo()
    {
        $tg = factory(App\TipoGarantia::class)->make(['dias' => -1]);
        $this->assertFalse($tg->isValid());
    }

    /**
     * @covers TipoGarantia::productos()
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
