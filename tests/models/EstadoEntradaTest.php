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

    /**
     * @covers ::entradas
     * @group relaciones
     */
    public function testEntradas()
    {
        $estado = factory(App\EstadoEntrada::class)->create();
        $entrada = factory(App\Entrada::class, 'full')->create(['estado_entrada_id' => $estado->id]);
        $entradas = $estado->entradas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $entradas);
        $this->assertInstanceOf(App\Entrada::class, $entradas[0]);
        $this->assertCount(1, $entradas);
    }
}
