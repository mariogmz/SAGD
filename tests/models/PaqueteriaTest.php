<?php

/**
 * @coversDefaultClass \App\Paqueteria
 */
class PaqueteriaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $paq = factory(App\Paqueteria::class)->make();
        $this->assertTrue($paq->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $paq = factory(App\Paqueteria::class)->create();
        $paq->nombre = 'MC Hammer';
        $this->assertTrue($paq->isValid('update'));
        $this->assertTrue($paq->save());
        $this->assertSame('MC Hammer', $paq->nombre);
    }

    /**
     * @coversNothing
     */
    public function testClaveEsObligatoria()
    {
        $paq = factory(App\Paqueteria::class)->make(['clave' => null]);
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveSeGuardaEnMayuscula()
    {
        $paq = factory(App\Paqueteria::class, 'lowerclave')->make();
        $clave = $paq->clave;
        $this->assertTrue($paq->isValid());
        $paq->save();
        $this->assertSame(strtoupper($clave), $paq->clave);
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeSerMasDe6Caracteres()
    {
        $paq = factory(App\Paqueteria::class)->make(['clave' => 'ABCABCD']);
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnica()
    {
        $paq = factory(App\Paqueteria::class)->make();
        $paq_dos = clone $paq;
        $paq->save();
        $this->assertFalse($paq_dos->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio()
    {
        $paq = factory(App\Paqueteria::class)->make(['nombre' => null]);
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo()
    {
        $paq = factory(App\Paqueteria::class, 'longnombre')->make();
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUrlEsOpcional()
    {
        $paq = factory(App\Paqueteria::class)->make(['url' => null]);
        $this->assertTrue($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUrlNoPuedeSerLarga()
    {
        $paq = factory(App\Paqueteria::class, 'longurl')->make();
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHorarioEsOpcional()
    {
        $paq = factory(App\Paqueteria::class)->make();
        $this->assertTrue($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHorarioNoPuedeSerLargo()
    {
        $paq = factory(App\Paqueteria::class, 'longhorario')->make();
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCondicionEntregaEsOpcional()
    {
        $paq = factory(App\Paqueteria::class)->make(['condicion_entrega' => null]);
        $this->assertTrue($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCondicionEntregaNoPuedeSerLargo()
    {
        $paq = factory(App\Paqueteria::class, 'longcondicion')->make();
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSeguroEsObligatorio()
    {
        $paq = factory(App\Paqueteria::class)->make(['seguro' => null]);
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSeguroEstaDentroDeLimites()
    {
        $paq = factory(App\Paqueteria::class)->make(['seguro' => -1.0]);
        $this->assertFalse($paq->isValid());
        $paq->seguro = 1.1;
        $this->assertFalse($paq->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSeguroEsDecimal()
    {
        $paq = factory(App\Paqueteria::class)->make(['seguro' => 'a']);
        $this->assertFalse($paq->isValid());
    }

    /**
     * @covers ::rangos
     * @group relaciones
     */
    public function testRangos()
    {
        $paqueteria = factory(App\Paqueteria::class)->create();
        $rango = factory(App\PaqueteriaRango::class)->create(['paqueteria_id' => $paqueteria->id]);
        $rangos = $paqueteria->rangos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rangos);
        $this->assertInstanceOf(App\PaqueteriaRango::class, $rangos[0]);
        $this->assertCount(1, $rangos);
    }

    /**
     * @covers ::paqueteriaCoberturas
     * @group relaciones
     */
    public function testPaqueteriaCoberturas()
    {
        $paqueteria = factory(App\Paqueteria::class)->create();
        $pc = factory(App\PaqueteriaCobertura::class, 'full')->create([
            'paqueteria_id' => $paqueteria->id]);
        $pcs = $paqueteria->paqueteriaCoberturas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pcs);
        $this->assertInstanceOf(App\PaqueteriaCobertura::class, $pcs[0]);
        $this->assertCount(1, $pcs);
    }

    /**
     * @covers ::coberturas
     * @group relaciones
     */
    public function testCoberturas()
    {
        $paqueteria = factory(App\Paqueteria::class)->create();
        $codigo_postal = factory(App\CodigoPostal::class)->create();
        $paqueteria->coberturas()->attach($codigo_postal, ['ocurre' => 10.0]);
        $coberturas = $paqueteria->coberturas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $coberturas);
        $this->assertInstanceOf(App\CodigoPostal::class, $coberturas[0]);
        $this->assertCount(1, $coberturas);
    }

    /**
     * @covers ::guias
     * @group relaciones
     */
    public function testGuias()
    {
        $paqueteria = factory(App\Paqueteria::class)->create();
        $guia = factory(App\Guia::class, 'full')->create(['paqueteria_id' => $paqueteria->id]);
        $guias = $paqueteria->guias;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $guias);
        $this->assertInstanceOf(App\Guia::class, $guias[0]);
        $this->assertCount(1, $guias);
    }
}
