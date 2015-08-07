<?php

/**
 * @coversDefaultClass \App\Garantia
 */
class GarantiaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testSerieEsRequerido() {
        $model = factory(App\Garantia::class)->make([
            'serie' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSerieEsDeMaximo45Caracteres() {
        $model = factory(App\Garantia::class, 'serielargo')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testVentaDetalleEsRequerido() {
        $model = factory(App\Garantia::class)->make([
            'venta_detalle_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::ventaDetalle
     * @group relaciones
     */
    public function testVentaDetalle() {
        $parent = factory(App\VentaDetalle::class, 'producto')->create();
        $child = factory(App\Garantia::class)->create([
            'venta_detalle_id' => $parent->id
        ]);
        $parent_result = $child->ventaDetalle;
        $this->assertInstanceOf('App\VentaDetalle', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::rmasDetalles
     * @group relaciones
     */
    public function testRmasDetalles() {
        $parent = factory(App\Garantia::class)->create();
        factory(App\RmaDetalle::class)->create([
            'garantia_id' => $parent->id
        ]);
        $children = $parent->rmasDetalles;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\RmaDetalle', $children[0]);
        $this->assertCount(1, $children);
    }

    /**
     * @covers ::reposiciones
     * @group relaciones
     */
    public function testReposiciones() {
        $parent = factory(App\Garantia::class)->create();
        factory(App\Reposicion::class)->create([
            'garantia_id' => $parent->id
        ]);
        $children = $parent->reposiciones;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Reposicion', $children[0]);
        $this->assertCount(1, $children);
    }



}
