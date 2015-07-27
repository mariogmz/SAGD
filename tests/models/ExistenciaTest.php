<?php

/**
* @coversDefaultClass \App\Existencia
*/
class ExistenciaTest extends TestCase
{
    protected $existencia;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $existencia = factory(App\Existencia::class)->make();
        $this->assertTrue($existencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadesNoPuedenSerNegativas()
    {
        $existencia = factory(App\Existencia::class, 'negativeamount')->make();
        $this->assertFalse($existencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadesTienenDefaultACero()
    {
        $existencia = factory(App\Existencia::class, 'nullamount')->make();
        $this->assertTrue($existencia->isValid());
        $this->markTestIncomplete('We need the productos_sucursales keys');
    }
}
