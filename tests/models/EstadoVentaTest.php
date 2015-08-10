<?php

/**
 * @coversDefaultClass \App\EstadoVenta
 */
class EstadoVentaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testClaveEsRequerida() {
        $estado_venta = factory(App\EstadoVenta::class)->make([
            'clave' => null
        ]);
        $this->assertFalse($estado_venta->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveDeUnSoloCaracter() {
        $estado_venta = factory(App\EstadoVenta::class)->make([
            'clave' => 'AAA'
        ]);
        $this->assertFalse($estado_venta->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnica() {
        $estado_venta1 = factory(App\EstadoVenta::class)->create();
        $estado_venta2 = factory(App\EstadoVenta::class)->make([
            'clave' => $estado_venta1->clave
        ]);
        $this->assertFalse($estado_venta2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsLetra() {
        $model = factory(App\EstadoVenta::class, 'clavenumero')->make();
        $this->assertFalse($model->isValid());
        $model = factory(App\EstadoVenta::class)->make();
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido() {
        $estado_venta = factory(App\EstadoVenta::class)->make([
            'nombre' => null
        ]);
        $this->assertFalse($estado_venta->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreDeMaximo60Caracteres() {
        $estado_venta = factory(App\EstadoVenta::class, 'nombrelargo')->make();
        $this->assertFalse($estado_venta->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $estado_venta = factory(App\EstadoVenta::class)->create();
        $estado_venta->nombre = 'Gollum';
        $this->assertTrue($estado_venta->isValid('update'));
        $this->assertTrue($estado_venta->save());
        $this->assertSame('Gollum', $estado_venta->nombre);
    }

    /**
     * @covers ::ventas
     * @group relaciones
     */
    public function testVentas() {
        $parent = factory(App\EstadoVenta::class)->create();
        factory(App\Venta::class)->create([
            'estado_venta_id' => $parent->id
        ]);
        $children = $parent->ventas;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Venta', $children[0]);
        $this->assertCount(1,$children);
    }

    /**
     * @covers ::ventasMovimientos
     * @group relaciones
     */
    public function testVentasMovimientos() {
        $parent = factory(App\EstadoVenta::class)->create();
        factory(App\VentaMovimiento::class)->create([
            'estado_venta_id' => $parent->id
        ]);
        $children = $parent->ventasMovimientos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\VentaMovimiento', $children[0]);
        $this->assertCount(1,$children);
    }

}
