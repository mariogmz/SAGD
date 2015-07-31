<?php

/**
 * @coversDefaultClass \App\ClienteAutorizacion
 */
class ClienteAutorizacionTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $ca = factory(App\ClienteAutorizacion::class)->make();
        $this->assertTrue($ca->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $ca = factory(App\ClienteAutorizacion::class)->make();
        $ca->cliente()->associate($cliente);
        $ca->nombre_autorizado = 'MC Hammer';
        $ca->cliente_autorizado_id = null;
        $this->assertTrue($ca->isValid('update'));
        $this->assertTrue($ca->save());
        $this->assertSame('MC Hammer', $ca->nombre_autorizado);
    }

    /**
     * @coversNothing
     */
    public function testClienteAutorizadoIdEsOpcional()
    {
        $ca = factory(App\ClienteAutorizacion::class, 'onlyname')->make();
        $this->assertTrue($ca->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreAutorizadoEsOpcional()
    {
        $ca = factory(App\ClienteAutorizacion::class, 'onlyclient')->make();
        $this->assertTrue($ca->isValid());
    }

    /**
     * @coversNothing
     */
    public function testConAmbosCamposEnInvalido()
    {
        $ca = factory(App\ClienteAutorizacion::class, 'both')->make();
        $this->assertFalse($ca->isValid());
    }

    /**
     * @covers ::clientes
     * @group relaciones
     */
    public function testClientes()
    {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $ca = factory(App\ClienteAutorizacion::class)->make();
        $ca->cliente()->associate($cliente);
        $cliente = $ca->cliente;
        $this->assertInstanceOf(App\Cliente::class, $cliente);
    }
}
