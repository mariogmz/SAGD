<?php

/**
 * @coversDefaultClass \App\EstadoSalida
 */
class EstadoSalidaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $es = factory(App\EstadoSalida::class)->make();
        $this->assertTrue($es->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $es = factory(App\EstadoSalida::class)->create();
        $name = "MCHammer" . rand();
        $es->nombre = $name;
        $this->assertTrue($es->isValid('update'));
        $this->assertTrue($es->save());
        $this->assertSame($name, $es->nombre);
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio()
    {
        $es = factory(App\EstadoSalida::class)->make(['nombre' => null]);
        $this->assertFalse($es->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo()
    {
        $es = factory(App\EstadoSalida::class, 'longname')->make();
        $this->assertFalse($es->isValid());
    }

    /**
     * @covers ::salidas
     * @group relaciones
     */
    public function testSalidas()
    {
        $es = factory(App\EstadoSalida::class)->create();
        $salida = factory(App\Salida::class, 'full')->create(['estado_salida_id' => $es->id]);
        $salidas = $es->salidas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $salidas);
        $this->assertInstanceOf(App\Salida::class, $salidas[0]);
        $this->assertCount(1, $salidas);
    }
}
