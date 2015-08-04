<?php

/**
 * @coversDefaultClass \App\TipoCorteConcepto
 */
class TipoCorteConceptoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido() {
        $model = factory(App\TipoCorteConcepto::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsMaximoDe45Caracteres() {
        $model = factory(App\TipoCorteConcepto::class, 'nombrelargo')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::cortesConceptos
     */
    public function testCortesConceptos() {
        $tipo_corte_concepto = factory(App\TipoCorteConcepto::class)->create();
        factory(App\CorteConcepto::class)->create([
            'tipo_corte_concepto_id' => $tipo_corte_concepto->id
        ]);
        $cortes_conceptos = $tipo_corte_concepto->cortesConceptos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $cortes_conceptos);
        $this->assertInstanceOf('App\CorteConcepto', $cortes_conceptos[0]);
        $this->assertCount(1, $cortes_conceptos);
    }
}
