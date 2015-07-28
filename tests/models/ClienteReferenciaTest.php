<?php

/**
 * @coversDefaultClass \App\ClienteReferencia
 */
class ClienteReferenciaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $referencia = factory(App\ClienteReferencia::class)->make();
        $this->assertTrue($referencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido()
    {
        $referencia = factory(App\ClienteReferencia::class)->make(['nombre' => null]);
        $this->assertFalse($referencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeTenerMasDe50Caracteres()
    {
        $referencia = factory(App\ClienteReferencia::class, 'longname')->make();
        $this->assertFalse($referencia->isValid());
    }

    /**
     * @covers ::clientes()
     */
    public function testClientes()
    {
        $this->markTestIncomplete('We need to save a Cliente to do this');
    }
}
