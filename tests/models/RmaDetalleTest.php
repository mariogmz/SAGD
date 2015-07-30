<?php

/**
 * @coversDefaultClass \App\RmaDetalle
 */
class RmaDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDescripcionFallaEsRequerido() {
        $rma_detalle = factory(App\RmaDetalle::class)->make([
            'descripcion_falla' => ''
        ]);
        $this->assertFalse($rma_detalle->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRmaEsRequerido() {
        $rma_detalle = factory(App\RmaDetalle::class)->make([
            'rma_id' => null
        ]);
        $this->assertFalse($rma_detalle->isValid());
    }

    /**
     * @coversNothing
     */
    public function testGarantiaEsRequerido() {
        $this->markTestIncomplete('Garantia class not implemented yet.');
        $rma_detalle = factory(App\RmaDetalle::class)->make([
            'garantia_id' => null
        ]);
        $this->assertFalse($rma_detalle->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProductoMovimientoEsRequerido() {
        $rma_detalle = factory(App\RmaDetalle::class)->make([
            'producto_movimiento_id' => null
        ]);
        $this->assertFalse($rma_detalle->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionFallaMaximo80Caracteres() {
        $rma_detalle = factory(App\RmaDetalle::class, 'descripcionfallalargo')->make();
        $this->assertFalse($rma_detalle->isValid());
    }

    /**
     * @covers ::rma
     */
    public function testRma() {
        $this->markTestIncomplete('Garantia class not implemented yet.');
        $rma = factory(App\Rma::class)->create();
        $rma_detalle = factory(App\RmaDetalle::class)->create([
            'rma_id' => $rma->id
        ]);
        $this->assertEquals($rma->id, $rma_detalle->rma->id);
    }

    /**
     * @covers ::garantia
     */
    public function testGarantia() {
        $this->markTestIncomplete('Garantia class not implemented yet.');
        $garantia = factory(App\Garantia::class)->create();
        $rma_detalle = factory(App\RmaDetalle::class)->create([
            'garantia_id' => $garantia->id
        ]);
        $this->assertEquals($garantia->id, $rma_detalle->rma->id);
    }

    /**
     * @covers ::productoMovimiento
     */
    public function testProductoMovimiento() {
        $this->markTestIncomplete('Garantia class not implemented yet.');
        $producto_movimiento = factory(App\ProductoMovimiento::class, 'withproduct')->create();
        $rma_detalle = factory(App\RmaDetalle::class)->create([
            'producto_movimiento_id' => $producto_movimiento->id
        ]);
        $this->assertEquals($producto_movimiento->id, $rma_detalle->rma->id);
    }
}
