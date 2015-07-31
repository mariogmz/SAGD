<?php

/**
 * @coversDefaultClass \App\EstadoEntrada
 */
class EstadoEntradaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $ee = factory(App\EstadoEntrada::class)->make();
        $this->assertTrue($ee->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $ee = factory(App\EstadoEntrada::class)->create();
        $name = "MCHammer" . rand();
        $ee->nombre = $name;
        $this->assertTrue($ee->isValid('update'));
        $this->assertTrue($ee->save());
        $this->assertSame($name, $ee->nombre);
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio()
    {
        $ee = factory(App\EstadoEntrada::class)->make(['nombre' => null]);
        $this->assertFalse($ee->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo()
    {
        $ee = factory(App\EstadoEntrada::class,'longnombre')->make();
        $this->assertFalse($ee->isValid());
    }
}
