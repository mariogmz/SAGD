<?php

/**
 * @coversDefaultClass \App\EstadoFactura
 */
class EstadoFacturaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $estado = factory(App\EstadoFactura::class)->make();
        $this->assertTrue($estado->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $estado = factory(App\EstadoFactura::class)->create();
        $estado->nombre = 'MC Hammer';
        $this->assertTrue($estado->isValid('update'));
        $this->assertTrue($estado->save());
        $this->assertSame('MC Hammer', $estado->nombre);
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio()
    {
        $estado = factory(App\EstadoFactura::class)->make(['nombre' => null]);
        $this->assertFalse($estado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo()
    {
        $estado = factory(App\EstadoFactura::class, 'longname')->make();
        $this->assertFalse($estado->isValid());
    }
}
