<?php

/**
 * @coversDefaultClass \App\RmaDetalle
 */
class RmaDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDescripcionFallaEsRequerido() {
        $model = factory(App\RmaDetalle::class)->make([
            'descripcion_falla' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionFallaEsMaximo80Caracteres() {
        $model = factory(App\RmaDetalle::class, 'descripcionfallalarga')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRmaEsRequerido() {
        $model = factory(App\RmaDetalle::class)->make([
            'rma_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testGarantiaEsRequerido() {
        $model = factory(App\RmaDetalle::class)->make([
            'garantia_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProductoMovimientoEsRequerido() {
        $model = factory(App\RmaDetalle::class)->make([
            'producto_movimiento_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::Rma
     * @group relaciones
     */
    public function testRma() {
        $parent = factory(App\Rma::class)->create();
        $child = factory(App\RmaDetalle::class)->create([
            'rma_id' => $parent->id
        ]);
        $parent_result = $child->Rma;
        $this->assertInstanceOf('App\Rma', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::garantia
     * @group relaciones
     */
    public function testGarantia() {
        $parent = factory(App\Garantia::class)->create();
        $child = factory(App\RmaDetalle::class)->create([
            'garantia_id' => $parent->id
        ]);
        $parent_result = $child->garantia;
        $this->assertInstanceOf('App\Garantia', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimiento() {
        $parent = factory(App\ProductoMovimiento::class, 'withproduct')->create();
        $child = factory(App\RmaDetalle::class)->create([
            'producto_movimiento_id' => $parent->id
        ]);
        $parent_result = $child->productoMovimiento;
        $this->assertInstanceOf('App\ProductoMovimiento', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

}
