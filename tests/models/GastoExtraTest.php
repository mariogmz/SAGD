<?php

/**
 * @coversDefaultClass \App\GastoExtra
 */
class GastoExtraTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testMontoEsRequerido() {
        $model = factory(App\GastoExtra::class)->make([
            'monto' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMontoEsDecimal() {
        $model = factory(App\GastoExtra::class)->make([
            'monto' => 'HelloWorld'
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testConceptoEsRequerido() {
        $model = factory(App\GastoExtra::class)->make([
            'concepto' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testConceptoEsDeMaximo45Caracteres() {
        $model = factory(App\GastoExtra::class, 'conceptolargo')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCajaEsRequerido() {
        $model = factory(App\GastoExtra::class)->make([
            'caja_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCorteEsRequerido() {
        $model = factory(App\GastoExtra::class)->make([
            'corte_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::caja
     */
    public function testCaja() {
        $caja = factory(App\Caja::class)->create();
        $gasto_extra = factory(App\GastoExtra::class)->create([
            'caja_id' => $caja->id
        ]);
        $caja_resultado = $gasto_extra->caja;
        $this->assertInstanceOf('App\Caja', $caja_resultado);
        $this->assertSame($caja->id, $caja_resultado->id);
    }

    /**
     * @covers ::cprte
     */
    public function testCorte() {
        $corte = factory(App\Corte::class)->create();
        $gasto_extra = factory(App\GastoExtra::class)->create([
            'corte_id' => $corte->id
        ]);
        $corte_resultado = $gasto_extra->corte;
        $this->assertInstanceOf('App\Corte', $corte_resultado);
        $this->assertSame($corte->id, $corte_resultado->id);
    }
}
