<?php

/**
 * @coversDefaultClass \App\DomicilioCliente
 */
class DomicilioClienteTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDomicilioIdEsRequerido() {
        $domicilio_cliente = factory(App\DomicilioCliente::class)->make();
        $domicilio_id = $domicilio_cliente->domicilio_id;
        unset($domicilio_cliente->domicilio_id);
        $this->assertFalse($domicilio_cliente->isValid());
        $domicilio_cliente->domicilio_id = $domicilio_id;
        $domicilio_cliente->isValid();
        $this->assertTrue($domicilio_cliente->isValid(),$domicilio_cliente->errors);
    }

    /**
     * @coversNothing
     */
    public function testDomicilioIdEsEntero() {
        $domicilio_cliente = factory(App\DomicilioCliente::class)->make();
        $domicilio_id = $domicilio_cliente->domicilio_id;
        $domicilio_cliente->domicilio_id = 'text';
        $this->assertFalse($domicilio_cliente->isValid());
        $domicilio_cliente->domicilio_id = $domicilio_id;
        $this->assertTrue($domicilio_cliente->isValid(),$domicilio_cliente->errors);
    }

    /**
     * @coversNothing
     */
    public function testClienteIdEsRequerido() {
        $domicilio_cliente = factory(App\DomicilioCliente::class)->make();
        $cliente_id = $domicilio_cliente->cliente_id;
        unset($domicilio_cliente->cliente_id);
        $this->assertFalse($domicilio_cliente->isValid());
        $domicilio_cliente->cliente_id = $cliente_id;
        $this->assertTrue($domicilio_cliente->isValid(),$domicilio_cliente->errors);

    }

    /**
     * @coversNothing
     */
    public function testClienteIdEsEntero() {
        $domicilio_cliente = factory(App\DomicilioCliente::class)->make();
        $cliente_id = $domicilio_cliente->cliente_id;
        $domicilio_cliente->cliente_id = 'text';
        $this->assertFalse($domicilio_cliente->isValid());
        $domicilio_cliente->cliente_id = $cliente_id;
        $this->assertTrue($domicilio_cliente->isValid(), $domicilio_cliente->errors);
    }

    /**
     * @coversNothing
     */
    public function testDomicilioIdClienteIdCombinacionUnica() {
        $domicilio_cliente = factory(App\DomicilioCliente::class)->create();
        $domicilio_cliente_test = factory(App\DomicilioCliente::class)->make();

        $this->assertTrue($domicilio_cliente_test->isValid(), $domicilio_cliente_test->errors);
        $domicilio_cliente_test->cliente_id = $domicilio_cliente->cliente_id;
        $this->assertTrue($domicilio_cliente_test->isValid());
        $domicilio_cliente_test->domicilio_id = $domicilio_cliente->domicilio_id;
        $this->assertFalse($domicilio_cliente_test->isValid());
    }

    /**
     * @covers ::domicilio
     */
    public function testDomicilio() {
        $domicilio = factory(App\Domicilio::class)->create();
        $domicilio_cliente = factory(App\DomicilioCliente::class)->create([
            'domicilio_id' => $domicilio->id
        ]);
        $domicilio_test = $domicilio_cliente->domicilio;
        $this->assertInstanceOf('App\Domicilio', $domicilio_test);
        $this->assertSame($domicilio->id, $domicilio_test->id);
    }

    /**
     * @covers ::cliente
     */
    public function testCliente() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $domicilio_cliente = factory(App\DomicilioCliente::class)->create([
            'cliente_id' => $cliente->id
        ]);
        $cliente_test = $domicilio_cliente->cliente;
        $this->assertInstanceOf('App\Cliente', $cliente_test);
        $this->assertSame($cliente->id, $cliente_test->id);

    }


}
