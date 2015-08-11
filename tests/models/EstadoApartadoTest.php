<?php

/**
 * @coversDefaultClass \App\EstadoApartado
 */
class EstadoApartadoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $ea = factory(App\EstadoApartado::class)->make();
        $this->assertTrue($ea->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $ea = factory(App\EstadoApartado::class)->create();
        $name = 'MCHammer'.rand();
        $ea->nombre = $name;
        $this->assertTrue($ea->isValid('update'));
        $this->assertTrue($ea->save());
        $this->assertSame($name, $ea->nombre);
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio()
    {
        $ea = factory(App\EstadoApartado::class)->make(['nombre' => null]);
        $this->assertFalse($ea->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo()
    {
        $ea = factory(App\EstadoApartado::class, 'longname')->make();
        $this->assertFalse($ea->isValid());
    }

    /**
     * @covers ::apartados
     * @group relaciones
     */
    public function testApartados()
    {
        $ea = factory(App\EstadoApartado::class)->create();
        $apartado = factory(App\Apartado::class, 'full')->create(['estado_apartado_id' => $ea->id]);
        $apartados = $ea->apartados;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $apartados);
        $this->assertInstanceOf(App\Apartado::class, $apartados[0]);
        $this->assertCount(1, $apartados);
    }
}
