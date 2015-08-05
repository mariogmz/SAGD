<?php

/**
 * @coversDefaultClass \App\NotaCredito
 */
class NotaCreditoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $nc = factory(App\NotaCredito::class)->make();
        $this->assertTrue($nc->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $nc = factory(App\NotaCredito::class, 'full')->create();
        $nc->metodo_pago = 'MC Hammer';
        $this->assertTrue($nc->isValid('update'));
        $this->assertTrue($nc->save());
        $this->assertSame('MC Hammer', $nc->metodo_pago);
    }

    /**
     * @coversNothing
     */
    public function testFolioEsObligatorio()
    {
        $nc = factory(App\NotaCredito::class)->make(['folio' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     *  @coversNothing
     */
    public function testFolioNoPuedeSerLargo()
    {
        $nc = factory(App\NotaCredito::class, 'longfolio')->make();
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpedicionEsOpcional()
    {
        $nc = factory(App\NotaCredito::class)->make(['fecha_expedicion' => null]);
        $this->assertTrue($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpedicionEsTimestamp()
    {
        $nc = factory(App\NotaCredito::class)->make(['fecha_expedicion' => 'a']);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaTimbradoEsOpcional()
    {
        $nc = factory(App\NotaCredito::class)->make(['fecha_timbrado' => null]);
        $this->assertTrue($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaTimbradoEsTimestamp()
    {
        $nc = factory(App\NotaCredito::class)->make(['fecha_timbrado' => 'a']);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCadenaOriginalEmisorEsObligatoria()
    {
        $nc = factory(App\NotaCredito::class)->make(['cadena_original_emisor' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCadenaOriginalReceptorEsObligatoria()
    {
        $nc = factory(App\NotaCredito::class)->make(['cadena_original_receptor' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testErrorSatEsObligatorio()
    {
        $nc = factory(App\NotaCredito::class)->make(['error_sat' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testErrorSatEsBooleano()
    {
        $nc = factory(App\NotaCredito::class)->make(['error_sat' => 'asd']);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFormaDePagoEsObligatoria()
    {
        $nc = factory(App\NotaCredito::class)->make(['forma_pago' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFormaDePagoNoPuedeSerLarga()
    {
        $nc = factory(App\NotaCredito::class, 'longformadepago')->make();
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMetodoDePagoEsObligatoria()
    {
        $nc = factory(App\NotaCredito::class)->make(['metodo_pago' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMetodoDePagoNoPuedeSerLarga()
    {
        $nc = factory(App\NotaCredito::class, 'longmetododepago')->make();
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroCuentaPagoEsObligatoria()
    {
        $nc = factory(App\NotaCredito::class)->make(['numero_cuenta_pago' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroCuentaPagoNoPuedeSerLarga()
    {
        $nc = factory(App\NotaCredito::class, 'longnumerocuenta')->make();
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLugarExpedicionEsObligatoria()
    {
        $nc = factory(App\NotaCredito::class)->make(['lugar_expedicion' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLugarExpedicionNoPuedeSerLarga()
    {
        $nc = factory(App\NotaCredito::class, 'longlugarexp')->make();
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSelloDigitalEmisorEsObligatorio()
    {
        $nc = factory(App\NotaCredito::class)->make(['sello_digital_emisor' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSelloDigitalSatEsObligatorio()
    {
        $nc = factory(App\NotaCredito::class)->make(['sello_digital_sat' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testXmlEsObligatorio()
    {
        $nc = factory(App\NotaCredito::class)->make(['xml' => null]);
        $this->assertFalse($nc->isValid());
    }

    /**
     * @covers ::razonSocialEmisor
     * @group relaciones
     */
    public function testRazonSocialEmisor()
    {
        $nc = factory(App\NotaCredito::class, 'full')->make();
        $rse = $nc->razonSocialEmisor;
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $rse);
    }

    /**
     * @covers ::razonSocialEmisor
     * @group relaciones
     */
    public function testRazonSocialEmisorAssociate()
    {
        $nc = factory(App\NotaCredito::class, 'full')->make(['razon_social_emisor_id' => null]);
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create();
        $nc->razonSocialEmisor()->associate($rse);
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $nc->razonSocialEmisor);
    }

    /**
     * @covers ::razonSocialEmisor
     * @group relaciones
     */
    public function testRazonSocialReceptor()
    {
        $nc = factory(App\NotaCredito::class, 'full')->make();
        $rsr = $nc->razonSocialReceptor;
        $this->assertInstanceOf(App\RazonSocialReceptor::class, $rsr);
    }

    /**
     * @covers ::razonSocialEmisor
     * @group relaciones
     */
    public function testRazonSocialReceptorAssociate()
    {
        $nc = factory(App\NotaCredito::class, 'full')->make(['razon_social_receptor_id' => null]);
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->create();
        $nc->razonSocialReceptor()->associate($rsr);
        $this->assertInstanceOf(App\RazonSocialReceptor::class, $nc->razonSocialReceptor);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $nc = factory(App\NotaCredito::class, 'full')->make();
        $estado = $nc->estado;
        $this->assertInstanceOf(App\EstadoFactura::class, $estado);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $nc = factory(App\NotaCredito::class, 'full')->make(['factura_status_id' => null]);
        $estado = factory(App\EstadoFactura::class)->create();
        $nc->estado()->associate($estado);
        $this->assertInstanceOf(App\EstadoFactura::class, $nc->estado);
    }
}
