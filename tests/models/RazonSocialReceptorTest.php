<?php

/**
 * @coversDefaultClass \App\RazonSocialReceptor
 */
class RazonSocialReceptorTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $rsr = factory(App\RazonSocialReceptor::class)->make();
        $this->assertTrue($rsr->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->create();
        $rsr->regimen = 'MC Hammer';
        $this->assertTrue($rsr->isValid('update'));
        $this->assertTrue($rsr->save());
        $this->assertSame('MC Hammer', $rsr->regimen);
    }

    /**
     * @coversNothing
     */
    public function testRfcEsOpcional()
    {
        $rsr = factory(App\RazonSocialReceptor::class)->make(['rfc' => null]);
        $this->assertTrue($rsr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRfcTieneFormatoValido()
    {
        $rsr = factory(App\RazonSocialReceptor::class)->make(['rfc' => 'ABCDABCDABCD1']);
        $this->assertFalse($rsr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRfcEsSoloDe13Caracteres()
    {
        $rsr = factory(App\RazonSocialReceptor::class)->make(['rfc' => 'a']);
        $this->assertFalse($rsr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRegimenEsOpcional()
    {
        $rsr = factory(App\RazonSocialReceptor::class)->make(['regimen' => null]);
        $this->assertTrue($rsr->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRegimenNoPuedeSerLargo()
    {
        $rsr = factory(App\RazonSocialReceptor::class, 'longregimen')->make();
        $this->assertFalse($rsr->isValid());
    }

    /**
     * @covers ::domicilio
     * @group relaciones
     */
    public function testDomicilio()
    {
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->make();
        $domicilio = $rsr->domicilio;
        $this->assertInstanceOf(App\Domicilio::class, $domicilio);
    }

    /**
     * @covers ::domicilio
     * @group relaciones
     */
    public function testDomicilioAssociate()
    {
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->make(['domicilio_id' => null]);
        $dom = factory(App\Domicilio::class)->create();
        $rsr->domicilio()->associate($dom);
        $this->assertInstanceOf(App\Domicilio::class, $rsr->domicilio);
    }

    /**
     * @covers ::cliente
     * @group relaciones
     */
    public function testCliente()
    {
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->make();
        $cliente = $rsr->cliente;
        $this->assertInstanceOf(App\Cliente::class, $cliente);
    }

    /**
     * @covers ::cliente
     * @group relaciones
     */
    public function testClienteAssociate()
    {
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->make(['cliente_id' => null]);
        $cliente = factory(App\Cliente::class, 'full')->create();
        $rsr->cliente()->associate($cliente);
        $this->assertInstanceOf(App\Cliente::class, $rsr->cliente);
    }

    /**
     * @covers ::facturas
     * @group relaciones
     */
    public function testFacturas()
    {
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->create();
        $factura = factory(App\Factura::class, 'full')->create([
            'razon_social_receptor_id' => $rsr->id]);
        $facturas = $rsr->facturas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $facturas);
        $this->assertInstanceOf(App\Factura::class, $facturas[0]);
        $this->assertCount(1, $facturas);
    }
}
