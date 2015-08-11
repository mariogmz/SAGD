<?php

/**
 * @coversDefaultClass \App\GuiaZona
 */
class GuiaZonaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $guia_zona = factory(App\GuiaZona::class)->make();
        $this->assertTrue($guia_zona->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $guia_zona = factory(App\GuiaZona::class, 'full')->create();
        $guia_zona->costo = 1991.0;
        $this->assertTrue($guia_zona->isValid('update'));
        $this->assertTrue($guia_zona->save());
        $this->assertSame(1991.0, $guia_zona->costo);
    }

    /**
     * @coversNothing
     */
    public function testCostoEsObligatorio()
    {
        $guia_zona = factory(App\GuiaZona::class)->make(['costo' => null]);
        $this->assertFalse($guia_zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoEsDecimal()
    {
        $guia_zona = factory(App\GuiaZona::class)->make(['costo' => 'null']);
        $this->assertFalse($guia_zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoEsPositivo()
    {
        $guia_zona = factory(App\GuiaZona::class)->make(['costo' => -1.0]);
        $this->assertFalse($guia_zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoSobrepesoEsObligatorio()
    {
        $guia_zona = factory(App\GuiaZona::class)->make(['costo_sobrepeso' => null]);
        $this->assertFalse($guia_zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoSobrepesoEsDecimal()
    {
        $guia_zona = factory(App\GuiaZona::class)->make(['costo_sobrepeso' => 'null']);
        $this->assertFalse($guia_zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoSobrepesoEsPositivo()
    {
        $guia_zona = factory(App\GuiaZona::class)->make(['costo_sobrepeso' => -1.0]);
        $this->assertFalse($guia_zona->isValid());
    }

    /**
     * @covers ::guia
     * @group relaciones
     */
    public function testGuia()
    {
        $guia_zona = factory(App\GuiaZona::class, 'full')->create();
        $guia = $guia_zona->guia;
        $this->assertInstanceOf(App\Guia::class, $guia);
    }

    /**
     * @covers ::guia
     * @group relaciones
     */
    public function testGuiaAssociate()
    {
        $guia_zona = factory(App\GuiaZona::class, 'full')->make(['guia_id' => null]);
        $guia = factory(App\Guia::class, 'full')->create();
        $guia_zona->guia()->associate($guia);
        $this->assertInstanceOf(App\Guia::class, $guia_zona->guia);
    }

    /**
     * @covers ::zona
     * @group relaciones
     */
    public function testZona()
    {
        $guia_zona = factory(App\GuiaZona::class, 'full')->create();
        $zona = $guia_zona->zona;
        $this->assertInstanceOf(App\Zona::class, $zona);
    }

    /**
     * @covers ::zona
     * @group relaciones
     */
    public function testZonaAssociate()
    {
        $guia_zona = factory(App\GuiaZona::class, 'full')->make(['zona_id' => null]);
        $zona = factory(App\Zona::class)->create();
        $guia_zona->zona()->associate($zona);
        $this->assertInstanceOf(App\Zona::class, $guia_zona->zona);
    }
}
