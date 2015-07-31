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
        $metodo_pago_rango = factory(App\MetodoPagoRango::class)->make([
            'desde' => 'desde'
        ]);
        $this->assertFalse($metodo_pago_rango->isValid());
        $metodo_pago_rango->desde = 0.50;
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
        $this->markTestIncomplete('MetodoPago Class is not implemented yet.');

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
        $this->markTestIncomplete('MetodoPago Class is not implemented yet.');

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
    public function testRangoDebeSerValido(){
        $this->markTestIncomplete('MetodoPago Class is not implemented yet, hard logic has not been planned');
        // Truncate table
        DB::statement("SET foreign_key_checks=0");
        DB::table('metodos_pagos_rangos')->truncate();
        DB::statement("SET foreign_key_checks=1");

        // Test ranges
        factory(App\MetodoPagoRango::class)->create([
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

        $this->assertFalse($rango_invalido->isValid());
        $this->assertTrue($rango_valido->save());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $this->markTestIncomplete('MetodoPago Class is not implemented yet.');

        $metodo_pago_rango = factory(App\MetodoPagoRango::class)->create();
        $metodo_pago_rango->valor = rand(0.01, 1.00);
        $this->assertTrue($metodo_pago_rango->isValid('update'));
        $this->assertTrue($metodo_pago_rango->save());
    }

    /**
     * @covers ::metodoPago
     * @group relaciones
     */
    public function testMetodoPago() {
        $this->markTestIncomplete('MetodoPago Class is not implemented yet.');
        $metodo_pago = factory(App\MetodoPago::class)->create();
        $metodo_pago_rango = factory(App\MetodoPagoRango::class)->create([
            'metodo_pago_rango_id' => $metodo_pago->id
        ]);
        $this->assertEquals($metodo_pago, $metodo_pago_rango->metodoPago);
    }
}
