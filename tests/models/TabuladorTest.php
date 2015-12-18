<?php

/**
 * @coversDefaultClass \App\Tabulador
 */
class TabuladorTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testValorEsOpcional() {
        $tabulador = factory(App\Tabulador::class)->make();
        unset($tabulador->valor);
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorEsEntero() {
        $tabulador = factory(App\Tabulador::class)->make([
            'valor' => 'Caaaaawwwrl'
        ]);
        $this->assertFalse($tabulador->isValid());
        $tabulador->valor = 1;
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function test_valor_es_entre_1_y_10() {
        $tabulador = factory(App\Tabulador::class)->make([
            'valor' => 20
        ]);
        $this->assertFalse($tabulador->isValid());
        $tabulador->valor = 1;
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorPorDefaultEsIgualAValorOriginal() {
        $tabulador = factory(App\Tabulador::class)->make();
        unset($tabulador->valor);
        $this->assertTrue($tabulador->save());
        $this->assertSame($tabulador->fresh()->valor_original, $tabulador->fresh()->valor);
    }


    /**
     * @coversNothing
     */
    public function testValorOriginalEsOpcional() {
        $tabulador = factory(App\Tabulador::class)->make();
        unset($tabulador->valor_original);
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorOriginalEsEntero() {
        $tabulador = factory(App\Tabulador::class)->make([
            'valor_original' => 'Paaaaawwwl'
        ]);
        $this->assertFalse($tabulador->isValid());
        $tabulador->valor_original = 1;
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function test_valor_original_es_entre_1_y_10() {
        $tabulador = factory(App\Tabulador::class)->make([
            'valor_original' => 20
        ]);
        $this->assertFalse($tabulador->isValid());
        $tabulador->valor_original = 1;
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorOriginalPorDefaultEs1() {
        $tabulador = factory(App\Tabulador::class)->make();
        unset($tabulador->valor_original);
        $this->assertTrue($tabulador->save());
        $this->assertSame(1, $tabulador->fresh()->valor);
    }

    /**
     * @coversNothing
     */
    public function testEspecialEsOpcional() {
        $tabulador = factory(App\Tabulador::class)->make();
        unset($tabulador->especial);
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEspecialEsBooleano() {
        $tabulador = factory(App\Tabulador::class)->make([
            'especial' => 'Whooosh'
        ]);
        $this->assertFalse($tabulador->isValid());
        $tabulador->especial = true;
        $this->assertTrue($tabulador->isValid());

    }

    /**
     * @coversNothing
     */
    public function testEspecialPorDefaultEsFalso() {
        $tabulador = factory(App\Tabulador::class)->make();
        unset($tabulador->especial);
        $this->assertFalse(boolval($tabulador->especial));
    }

    /**
     * @coversNothing
     */
    public function testClienteIdEsRequerido() {
        $tabulador = factory(App\Tabulador::class)->make();
        unset($tabulador->cliente_id);
        $this->assertFalse($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClienteIdEsUnEntero() {
        $tabulador = factory(App\Tabulador::class)->make();
        $cliente_id = $tabulador->cliente_id;
        $tabulador->cliente_id = 'Whooosh!';
        $this->assertFalse($tabulador->isValid());
        $tabulador->cliente_id = $cliente_id;
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalIdEsRequerido() {
        $tabulador = factory(App\Tabulador::class)->make();
        unset($tabulador->sucursal_id);
        $this->assertFalse($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalIdEsUnEntero() {
        $tabulador = factory(App\Tabulador::class)->make();
        $sucursal_id = $tabulador->sucursal_id;
        $tabulador->sucursal_id = 'Whooosh!';
        $this->assertFalse($tabulador->isValid());
        $tabulador->sucursal_id = $sucursal_id;
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUnClienteSoloPuedeTenerUnTabuladorPorSucursal() {
        $tabulador = factory(App\Tabulador::class)->create();
        $tabulador_test = factory(App\Tabulador::class)->make();

        $cliente_id = $tabulador_test->cliente_id;
        $sucursal_id = $tabulador_test->sucursal_id;
        $tabulador_test->cliente_id = $tabulador->cliente_id;
        $tabulador_test->sucursal_id = $tabulador->sucursal_id;

        $this->assertFalse($tabulador_test->isValid());
        $tabulador_test->cliente_id = $cliente_id;
        $this->assertTrue($tabulador_test->isValid());
        $tabulador_test->sucursal_id = $sucursal_id;
        $this->assertTrue($tabulador_test->isValid());
    }

    /**
     * @covers ::cliente
     * @group relaciones
     */
    public function testCliente() {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal() {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
