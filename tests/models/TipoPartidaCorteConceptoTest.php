<?php

/**
 * @coversDefaultClass \App\TipoPartidaCorteConcepto
 */
class TipoPartidaCorteConceptoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testTipoPartidaEsRequerido() {
        $model = factory(App\TipoPartidaCorteConcepto::class)->make([
            'tipo_partida_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCorteConceptoEsRequerido() {
        $model = factory(App\TipoPartidaCorteConcepto::class)->make([
            'corte_concepto_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::tipoPartida
     */
    public function testTipoPartida() {
        $parent = factory(App\TipoPartida::class)->create();
        $child = factory(App\TipoPartidaCorteConcepto::class)->create([
            'tipo_partida_id' => $parent->id
        ]);
        $parent_result = $child->tipoPartida;
        $this->assertInstanceOf('App\TipoPartida', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::corteConcepto
     */
    public function testCorteConcepto() {
        $parent = factory(App\CorteConcepto::class)->create();
        $child = factory(App\TipoPartidaCorteConcepto::class)->create([
            'corte_concepto_id' => $parent->id
        ]);
        $parent_result = $child->corteConcepto;
        $this->assertInstanceOf('App\CorteConcepto', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }
}
