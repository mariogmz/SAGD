<?php

/**
 * @coversDefaultClass \App\CorteConcepto
 */
class CorteConceptoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido() {
        $model = factory(App\CorteConcepto::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsMaximo45Caracteres() {
        $model = factory(App\CorteConcepto::class, 'nombrelargo')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoCorteEsRequerido() {
        $model = factory(App\CorteConcepto::class)->make([
            'tipo_corte_concepto_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::tipoCorteConcepto
     * @group relaciones
     */
    public function testTipoCorteConcepto() {
        $tipo_corte_concepto = factory(App\TipoCorteConcepto::class)->create();
        $corte_concepto = factory(App\CorteConcepto::class)->create([
            'tipo_corte_concepto_id' => $tipo_corte_concepto->id
        ]);
        $tipo_corte_concepto_resultado = $corte_concepto->tipoCorteConcepto;
        $this->assertInstanceOf('App\TipoCorteConcepto', $tipo_corte_concepto_resultado);
        $this->assertSame($tipo_corte_concepto->id, $tipo_corte_concepto_resultado->id);
    }

    /**
     * @covers ::cortesDetalles
     * @group relaciones
     */
    public function testCortesDetalles() {
        $parent = factory(App\CorteConcepto::class)->create();
        factory(App\CorteDetalle::class)->create([
            'corte_concepto_id' => $parent->id
        ]);
        $children = $parent->cortesDetalles;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\CorteDetalle', $children[0]);
        $this->assertCount(1, $children);
    }

}
