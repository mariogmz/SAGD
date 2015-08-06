<?php

/**
 * @coversDefaultClass \App\PaqueteriaRango
 */
class PaqueteriaRangoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $pr = factory(App\PaqueteriaRango::class)->make();
        $this->assertTrue($pr->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $pr = factory(App\PaqueteriaRango::class, 'full')->create();
        $pr->valor = 0.65;
        $this->assertTrue($pr->isValid('update'));
        $this->assertTrue($pr->save());
        $this->assertSame(0.65, $pr->valor);
    }

    /**
     * @coversNothing
     */
    public function testDesdeEsObligatorio()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['desde' => null]);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHastaEsObligatorio()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['hasta' => null]);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorEsObligatorio()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['valor' => null]);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDistribuidorEsObligatorio()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['distribuidor' => null]);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDesdeEsDecimal()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['desde' => 'a']);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHastaEsDecimal()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['hasta' => 'a']);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorEsDecimal()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['valor' => 'a']);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDistribuidorEsBoolean()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['distribuidor' => 'a']);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHastaEsMayorQueDesde()
    {
        $pr = factory(App\PaqueteriaRango::class)->make(['desde' => 0.6, 'hasta' => 0.3]);
        $this->assertFalse($pr->isValid());
    }

    /**
     * @covers ::paqueteria
     * @group relaciones
     */
    public function testPaqueteria()
    {
        $pr = factory(App\PaqueteriaRango::class, 'full')->make();
        $paqueteria = $pr->paqueteria;
        $this->assertInstanceOf(App\Paqueteria::class, $paqueteria);
    }
}
