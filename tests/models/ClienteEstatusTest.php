<?php

/**
 * @coversDefaultClass \App\ClienteEstatus
 */
class ClienteEstatusTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $clienteE = factory(App\ClienteEstatus::class)->make();
        $this->assertTrue($clienteE->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido()
    {
        $clienteE = factory(App\ClienteEstatus::class)->make(['nombre' => null]);
        $this->assertFalse($clienteE->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerMasDe45Caracteres()
    {
        $clienteE = factory(App\ClienteEstatus::class, 'longname')->make();
        $this->assertFalse($clienteE->isValid());
    }

    /**
     * @covers ::clientes
     */
    public function testClientes()
    {
        $estatus = factory(App\ClienteEstatus::class)->create();
        $cliente = factory(App\Cliente::class)->make();
        $this->markTestIncomplete('As long as we cant save a client we cant do this');
    }
}
