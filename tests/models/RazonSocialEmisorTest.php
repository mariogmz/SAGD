<?php

/**
 * @coversDefaultClass \App\RazonSocialEmisor
 */
class RazonSocialEmisorTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make();
        $this->assertTrue($rse->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create();
        $rse->regimen = 'MC Hammer';
        $this->assertTrue($rse->isValid('update'));
        $this->assertTrue($rse->save());
        $this->assertSame('MC Hammer', $rse->regimen);
    }

    /**
     * @coversNothing
     */
    public function testRfcEsObligatorio()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['rfc' => null]);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRfcDebeTenerFormatoCorrecto()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['rfc' => 'asd']);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRfcEsExactamenteDe13Caracteres()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['rfc' => 'a']);
        $this->assertFalse($rse->isValid());
        $rse = factory(App\RazonSocialEmisor::class)->make(['rfc' => 'aaaaaaaaaaaaa']);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRegimenEsObligatorio()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['regimen' => null]);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRegimenNoPuedeSerLargo()
    {
        $rse = factory(App\RazonSocialEmisor::class, 'longregimen')->make();
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSerieEsObligatorio()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['serie' => null]);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSerieNoPuedeSerMayorA3Caracteres()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['serie' => 'aaaa']);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUltimoFolioEsObligatorio()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['ultimo_folio' => null]);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUltimoFolioEsEntero()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['ultimo_folio' => 'a']);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroCertificadoEsObligatorio()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['numero_certificado' => null]);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroCertificadoEsEntero()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['numero_certificado' => 'a']);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroCertificadoSatEsObligatorio()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['numero_certificado_sat' => null]);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroCertificadoSatEsEntero()
    {
        $rse = factory(App\RazonSocialEmisor::class)->make(['numero_certificado_sat' => 'a']);
        $this->assertFalse($rse->isValid());
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $rse = factory(App\RazonSocialEmisor::class, 'full')->make();
        $sucursal = $rse->sucursal;
        $this->assertInstanceOf(App\Sucursal::class, $sucursal);
    }

    /**
     * @covers ::domicilio
     * @group relaciones
     */
    public function testDomicilio()
    {
        $rse = factory(App\RazonSocialEmisor::class, 'full')->make();
        $domicilio = $rse->domicilio;
        $this->assertInstanceOf(App\Domicilio::class, $domicilio);
    }

    /**
     * @covers ::entradas
     * @group relaciones
     */
    public function testEntradas()
    {
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create();
        $entrada = factory(App\Entrada::class, 'full')->create(['razon_social_id' => $rse->id]);
        $entradas = $rse->entradas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $entradas);
        $this->assertInstanceOf(App\Entrada::class, $entradas[0]);
        $this->assertCount(1, $entradas);
    }

    /**
     * @covers ::facturas
     * @group relaciones
     */
    public function testFacturas()
    {
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create();
        $factura = factory(App\Factura::class, 'full')->create([
            'razon_social_emisor_id' => $rse->id]);
        $facturas = $rse->facturas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $facturas);
        $this->assertInstanceOf(App\Factura::class, $facturas[0]);
        $this->assertCount(1, $facturas);
    }

    /**
     * @covers ::notasCreditos
     * @group relaciones
     */
    public function testNotasCreditos()
    {
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create();
        $nc = factory(App\NotaCredito::class, 'full')->create([
            'razon_social_emisor_id' => $rse->id]);
        $ncs = $rse->notasCreditos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $ncs);
        $this->assertInstanceOf(App\NotaCredito::class, $ncs[0]);
        $this->assertCount(1, $ncs);
    }
}
