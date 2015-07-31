<?php

/**
 * @coversDefaultClass \App\SoporteProducto
 */
class SoporteProductoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testCantidadEsRequerido() {
        $soporte_producto = factory(App\SoporteProducto::class)->make([
            'cantidad' => null
        ]);
        $this->assertFalse($soporte_producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPrecioEsRequerido() {
        $soporte_producto = factory(App\SoporteProducto::class)->make([
            'precio' => null
        ]);
        $this->assertFalse($soporte_producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSoporteEsRequerido() {
        $soporte_producto = factory(App\SoporteProducto::class)->make([
            'servicio_soporte_id' => null
        ]);
        $this->assertFalse($soporte_producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProductoEsRequerido() {
        $soporte_producto = factory(App\SoporteProducto::class)->make([
            'producto_id' => null
        ]);
        $this->assertFalse($soporte_producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPrecioEsDecimal() {
        $soporte_producto = factory(App\SoporteProducto::class)->make([
            'precio' => 'HelloParkingMeter'
        ]);
        $this->assertFalse($soporte_producto->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $model = factory(App\SoporteProducto::class)->create();
        $model->precio = 20.50 + rand(1,1000);
        $this->assertTrue($model->isValid('update'));
        $this->assertTrue($model->save());
    }

    /**
     * @covers ::servicioSoporte
     */
    public function testServicioSoporte() {
        $soporte = factory(App\ServicioSoporte::class)->create();
        $soporte_producto = factory(App\SoporteProducto::class)->create([
            'servicio_soporte_id' => $soporte->id
        ]);
        $this->assertEquals(App\ServicioSoporte::find($soporte->id), $soporte_producto->servicioSoporte);
    }

    /**
     * @covers ::producto
     */
    public function testProducto() {
        $producto = factory(App\Producto::class)->create();
        $soporte_producto = factory(App\SoporteProducto::class)->create([
            'producto_id' => $producto->id
        ]);
        $this->assertEquals(App\Producto::find($producto->id), $soporte_producto->producto);
    }
}
