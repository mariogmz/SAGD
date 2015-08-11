<?php

/**
 * @coversDefaultClass \App\TipoVenta
 */
class TipoVentaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido() {
        $model = factory(App\TipoVenta::class)->make([
            'nombre' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsMaximo60Caracteres() {
        $model = factory(App\TipoVenta::class, 'nombrelargo')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::ventas
     * @group relaciones
     */
    public function testVentas() {
        $parent = factory(App\TipoVenta::class)->create();
        factory(App\Venta::class)->create([
            'tipo_venta_id' => $parent->id
        ]);
        $children = $parent->ventas;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Venta', $children[0]);
        $this->assertCount(1, $children);
    }



}
