<?php

/**
 * @coversDefaultClass \App\EstadoTransferencia
 */
class EstadoTransferenciaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $et = factory(App\EstadoTransferencia::class)->make();
        $this->assertTrue($et->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $et = factory(App\EstadoTransferencia::class)->create();
        $name = 'MCHammer'.rand();
        $et->nombre = $name;
        $this->assertTrue($et->isValid('update'));
        $this->assertTrue($et->save());
        $this->assertSame($name, $et->nombre);
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio()
    {
        $et = factory(App\EstadoTransferencia::class)->make(['nombre' => null]);
        $this->assertFalse($et->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo()
    {
        $et = factory(App\EstadoTransferencia::class, 'longname')->make();
        $this->assertFalse($et->isValid());
    }
}
