<?php

/**
 * @coversDefaultClass \App\MetodoPagoRango
 */
class MetodoPagoRangoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDesdeEsRequerido() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class)->make([
            'desde' => null
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHastaEsRequerido() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class)->make([
            'hasta' => null
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorEsRequerido() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class)->make([
            'hasta' => null
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDesdeEsPorcentaje() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class, 'truncate')->make([
            'desde' => 'desde'
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
        $metodo_pago_rango->desde = 0.50;
        if (!$metodo_pago_rango->isValid()) print_r($metodo_pago_rango);
        $this->assertTrue($metodo_pago_rango->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHastaEsPorcentaje() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class, 'random')->make([
            'hasta' => 'hasta'
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
        $metodo_pago_rango->hasta = 0.50;
        $this->assertTrue($metodo_pago_rango->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorEsPorcentaje() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class, 'random')->make([
            'valor' => 'valor'
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
        $metodo_pago_rango->valor = 0.50;
        $this->assertTrue($metodo_pago_rango->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMetodoPagoEsRequerido() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class)->make([
            'metodo_pago_id' => null
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHastaDebeSerMayorQueDesde() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class)->make([
            'desde' => 0.40,
            'hasta' => 0.30
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
        $metodo_pago_rango->hasta = 0.50;
        $this->assertTrue($metodo_pago_rango->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDesdeDebeSerUnico() {

        $rango1 = factory(App\MetodoPagoRango::class)->create([
            'desde' => 0.10,
            'hasta' => 0.20
        ]);
        $rango2 = factory(App\MetodoPagoRango::class)->make([
            'desde' => $rango1->desde,
            'hasta' => 1.00
        ]);
        $this->assertFalse($rango2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHastaDebeSerUnico() {

        $rango1 = factory(App\MetodoPagoRango::class)->create([
            'desde' => 0.10,
            'hasta' => 0.20
        ]);
        $rango2 = factory(App\MetodoPagoRango::class)->make([
            'desde' => 0.15,
            'hasta' => $rango1->hasta
        ]);
        $this->assertFalse($rango2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRangoDebeSerValido() {
        // $this->markTestIncomplete('Lógica de los rangos no implementada');
        // Test ranges
        factory(App\MetodoPagoRango::class, 'truncate')->create([
            'desde' => 0.00,
            'hasta' => 0.25
        ]);
        factory(App\MetodoPagoRango::class)->create([
            'desde' => 0.76,
            'hasta' => 1.00
        ]);
        $rango_invalido = factory(App\MetodoPagoRango::class)->make([
            'desde' => 0.20,
            'hasta' => 0.80
        ]);
        $rango_valido = factory(App\MetodoPagoRango::class)->make([
            'desde' => 0.56,
            'hasta' => 0.75
        ]);
        $this->assertFalse($rango_invalido->save(), 'El rango de 0.20 a 0.80 debe ser inválido');
        $this->assertTrue($rango_valido->save(), 'El rango de 0.56 a 0.75 debe ser válido');
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $metodo_pago_rango = factory(App\MetodoPagoRango::class, 'truncate')->create();
        $metodo_pago_rango->valor = rand(0.01, 1.00);
        $this->assertTrue($metodo_pago_rango->isValid('update'));
        $this->assertTrue($metodo_pago_rango->save());
    }

    /**
     * @covers ::metodoPago
     * @group relaciones
     */
    public function testMetodoPago() {
        $parent = factory(App\MetodoPago::class)->create();
        $child = factory(App\MetodoPagoRango::class)->create([
            'metodo_pago_id' => $parent->id
        ]);
        $parent_result = $child->metodoPago;
        $this->assertInstanceOf('App\MetodoPago', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

}
