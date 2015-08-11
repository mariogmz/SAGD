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
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $cr = factory(App\ClienteReferencia::class)->create();
        $cr->nombre = 'MC Hammer';
        $this->assertTrue($cr->isValid('update'));
        $this->assertTrue($cr->save());
        $this->assertSame('MC Hammer', $cr->nombre);
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
     * @covers ::clientes
     * @group relaciones
     */
    public function testClientes()
    {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $cr = factory(App\ClienteReferencia::class)->create();
        $cr->clientes()->save($cliente);
        $clientes = $cr->clientes;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $clientes);
        $this->assertInstanceOf(App\Cliente::class, $clientes[0]);
    }
}
