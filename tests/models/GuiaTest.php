<?php

/**
 * @coversDefaultClass \App\Guia
 */
class GuiaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $guia = factory(App\Guia::class)->make();
        $this->assertTrue($guia->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $guia = factory(App\Guia::class, 'full')->create();
        $guia->nombre = 'MC Hammer';
        $this->assertTrue($guia->isValid('update'));
        $this->assertTrue($guia->save());
        $this->assertSame('MC Hammer', $guia->nombre);
    }

    /**
     * @coversNothing
     */
    public function testNombreEsOpcional()
    {
        $guia = factory(App\Guia::class)->make(['nombre' => null]);
        $this->assertTrue($guia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo()
    {
        $guia = factory(App\Guia::class, 'longnombre')->make();
        $this->assertFalse($guia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testVolumenMaximoEsObligatorio()
    {
        $guia = factory(App\Guia::class)->make(['volumen_maximo' => null]);
        $this->assertFalse($guia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testVolumenMaximoEsDecimal()
    {
        $guia = factory(App\Guia::class)->make(['volumen_maximo' => 'null']);
        $this->assertFalse($guia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testVolumenMaximoEsPositivo()
    {
        $guia = factory(App\Guia::class)->make(['volumen_maximo' => -1.0]);
        $this->assertFalse($guia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testAmparaHastaEsObligatorio()
    {
        $guia = factory(App\Guia::class)->make(['ampara_hasta' => null]);
        $this->assertFalse($guia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testAmparaHastaEsDecimal()
    {
        $guia = factory(App\Guia::class)->make(['ampara_hasta' => 'null']);
        $this->assertFalse($guia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testAmparaHastaEsPositivo()
    {
        $guia = factory(App\Guia::class)->make(['ampara_hasta' => -1.0]);
        $this->assertFalse($guia->isValid());
    }

    /**
     * @covers ::paqueteria
     * @group relaciones
     */
    public function testPaqueteria()
    {
        $guia = factory(App\Guia::class, 'full')->make();
        $paqueteria = $guia->paqueteria;
        $this->assertInstanceOf(App\Paqueteria::class, $paqueteria);
    }

    /**
     * @covers ::estatus
     * @group relaciones
     */
    public function testEstatus()
    {
        $guia = factory(App\Guia::class, 'full')->make();
        $estatus = $guia->estatus;
        $this->assertInstanceOf(App\EstatusActivo::class, $estatus);
    }
}
