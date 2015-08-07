<?php

/**
 * @coversDefaultClass \App\Factura
 */
class FacturaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $factura = factory(App\Factura::class)->make();
        $this->assertTrue($factura->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $factura = factory(App\Factura::class, 'full')->create();
        $factura->metodo_pago = 'MC Hammer';
        $this->assertTrue($factura->isValid('update'));
        $this->assertTrue($factura->save());
        $this->assertSame('MC Hammer', $factura->metodo_pago);
    }

    /**
     * @coversNothing
     */
    public function testFolioEsObligatorio()
    {
        $factura = factory(App\Factura::class)->make(['folio' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     *  @coversNothing
     */
    public function testFolioNoPuedeSerLargo()
    {
        $factura = factory(App\Factura::class, 'longfolio')->make();
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpedicionEsOpcional()
    {
        $factura = factory(App\Factura::class)->make(['fecha_expedicion' => null]);
        $this->assertTrue($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpedicionEsTimestamp()
    {
        $factura = factory(App\Factura::class)->make(['fecha_expedicion' => 'a']);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaTimbradoEsOpcional()
    {
        $factura = factory(App\Factura::class)->make(['fecha_timbrado' => null]);
        $this->assertTrue($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaTimbradoEsTimestamp()
    {
        $factura = factory(App\Factura::class)->make(['fecha_timbrado' => 'a']);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCadenaOriginalEmisorEsObligatoria()
    {
        $factura = factory(App\Factura::class)->make(['cadena_original_emisor' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCadenaOriginalReceptorEsObligatoria()
    {
        $factura = factory(App\Factura::class)->make(['cadena_original_receptor' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testErrorSatEsObligatorio()
    {
        $factura = factory(App\Factura::class)->make(['error_sat' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testErrorSatEsBooleano()
    {
        $factura = factory(App\Factura::class)->make(['error_sat' => 'asd']);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFormaDePagoEsObligatoria()
    {
        $factura = factory(App\Factura::class)->make(['forma_pago' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFormaDePagoNoPuedeSerLarga()
    {
        $factura = factory(App\Factura::class, 'longformadepago')->make();
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMetodoDePagoEsObligatoria()
    {
        $factura = factory(App\Factura::class)->make(['metodo_pago' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMetodoDePagoNoPuedeSerLarga()
    {
        $factura = factory(App\Factura::class, 'longmetododepago')->make();
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroCuentaPagoEsObligatoria()
    {
        $factura = factory(App\Factura::class)->make(['numero_cuenta_pago' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroCuentaPagoNoPuedeSerLarga()
    {
        $factura = factory(App\Factura::class, 'longnumerocuenta')->make();
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLugarExpedicionEsObligatoria()
    {
        $factura = factory(App\Factura::class)->make(['lugar_expedicion' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLugarExpedicionNoPuedeSerLarga()
    {
        $factura = factory(App\Factura::class, 'longlugarexp')->make();
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSelloDigitalEmisorEsObligatorio()
    {
        $factura = factory(App\Factura::class)->make(['sello_digital_emisor' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSelloDigitalSatEsObligatorio()
    {
        $factura = factory(App\Factura::class)->make(['sello_digital_sat' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @coversNothing
     */
    public function testXmlEsObligatorio()
    {
        $factura = factory(App\Factura::class)->make(['xml' => null]);
        $this->assertFalse($factura->isValid());
    }

    /**
     * @covers ::razonSocialEmisor
     * @group relaciones
     */
    public function testRazonSocialEmisor()
    {
        $factura = factory(App\Factura::class, 'full')->make();
        $rse = $factura->razonSocialEmisor;
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $rse);
    }

    /**
     * @covers ::razonSocialEmisor
     * @group relaciones
     */
    public function testRazonSocialEmisorAssociate()
    {
        $factura = factory(App\Factura::class, 'full')->make(['razon_social_emisor_id' => null]);
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create();
        $factura->razonSocialEmisor()->associate($rse);
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $factura->razonSocialEmisor);
    }

    /**
     * @covers ::razonSocialEmisor
     * @group relaciones
     */
    public function testRazonSocialReceptor()
    {
        $factura = factory(App\Factura::class, 'full')->make();
        $rsr = $factura->razonSocialReceptor;
        $this->assertInstanceOf(App\RazonSocialReceptor::class, $rsr);
    }

    /**
     * @covers ::razonSocialEmisor
     * @group relaciones
     */
    public function testRazonSocialReceptorAssociate()
    {
        $factura = factory(App\Factura::class, 'full')->make(['razon_social_receptor_id' => null]);
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->create();
        $factura->razonSocialReceptor()->associate($rsr);
        $this->assertInstanceOf(App\RazonSocialReceptor::class, $factura->razonSocialReceptor);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $factura = factory(App\Factura::class, 'full')->make();
        $estado = $factura->estado;
        $this->assertInstanceOf(App\EstadoFactura::class, $estado);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $factura = factory(App\Factura::class, 'full')->make(['factura_status_id' => null]);
        $estado = factory(App\EstadoFactura::class)->create();
        $factura->estado()->associate($estado);
        $this->assertInstanceOf(App\EstadoFactura::class, $factura->estado);
    }

    /**
     * @covers ::ventasDetalles
     * @group relaciones
     */
    public function testVentasDetalles() {
        $parent = factory(App\Factura::class, 'full')->create();
        factory(App\VentaDetalle::class, 'producto')->create([
            'factura_id' => $parent->id
        ]);
        $children = $parent->ventasDetalles;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\VentaDetalle', $children[0]);
        $this->assertCount(1, $children);
    }

}
