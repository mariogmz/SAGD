<?php

/**
 * @coversDefaultClass \App\PaqueteriaCobertura
 */
class PaqueteriaCoberturaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $pc = factory(App\PaqueteriaCobertura::class)->make();
        $this->assertTrue($pc->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $pc = factory(App\PaqueteriaCobertura::class, 'full')->create();
        $pc->ocurre = 1991.0;
        $this->assertTrue($pc->isValid('update'));
        $this->assertTrue($pc->save());
        $this->assertSame(1991.0, $pc->ocurre);
    }

    /**
     * @coversNothing
     */
    public function testOcurreEsObligatorio()
    {
        $pc = factory(App\PaqueteriaCobertura::class)->make(['ocurre' => null]);
        $this->assertFalse($pc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testOcurreEsDecimal()
    {
        $pc = factory(App\PaqueteriaCobertura::class)->make(['ocurre' => 'null']);
        $this->assertFalse($pc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testOcurreEsPositivo()
    {
        $pc = factory(App\PaqueteriaCobertura::class)->make(['ocurre' => -1.0]);
        $this->assertFalse($pc->isValid());
    }

    /**
     * @covers ::paqueteria
     * @group relaciones
     */
    public function testPaqueteria()
    {
        $pc = factory(App\PaqueteriaCobertura::class, 'full')->make();
        $paqueteria = $pc->paqueteria;
        $this->assertInstanceOf(App\Paqueteria::class, $paqueteria);
    }

    /**
     * @covers ::codigoPostal
     * @group relaciones
     */
    public function testCodigoPostal()
    {
        $pc = factory(App\PaqueteriaCobertura::class, 'full')->make();
        $cp = $pc->codigoPostal;
        $this->assertInstanceOf(App\CodigoPostal::class, $cp);
    }
}
