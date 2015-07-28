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
}
