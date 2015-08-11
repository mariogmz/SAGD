<?php

/**
 * @coversDefaultClass \App\CorteDetalle
 */
class CorteDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testMontoEsRequerido() {
        $model = factory(App\CorteDetalle::class)->make([
            'monto' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMontoEsDecimal() {
        $model = factory(App\CorteDetalle::class)->make([
            'monto' => 'ImSoHungry'
        ]);
        $this->assertFalse($model->isValid());
        $model->monto = 10.50;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCorteEsRequerido() {
        $model = factory(App\CorteDetalle::class)->make([
            'corte_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCorteConceptoEsRequerido() {
        $model = factory(App\CorteDetalle::class)->make([
            'corte_concepto_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }


    /**
     * @covers ::corte
     * @group relaciones
     */
    public function testCorte() {
        $parent = factory(App\Corte::class)->create();
        $child = factory(App\CorteDetalle::class)->create([
            'corte_id' => $parent->id
        ]);
        $parent_result = $child->corte;
        $this->assertInstanceOf('App\Corte', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::corteConcepto
     * @group relaciones
     */
    public function testCorteConcepto() {
        $parent = factory(App\CorteConcepto::class)->create();
        $child = factory(App\CorteDetalle::class)->create([
            'corte_concepto_id' => $parent->id
        ]);
        $parent_result = $child->corteConcepto;
        $this->assertInstanceOf('App\CorteConcepto', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

}
