<?php

/**
 * @coversDefaultClass \App\VentaMovimiento
 */
class VentaMovimientoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testTieneTimestamps() {
        $model = factory(App\VentaMovimiento::class)->create();
        if ($model->touch()) {
            $this->assertNotEmpty($model->created_at);
            $this->assertNotEmpty($model->updated_at);
        }
        $this->assertTrue($model->timestamps);
    }

    /**
     * @coversNothing
     */
    public function testVentaEsRequerido() {
        $model = factory(App\VentaMovimiento::class)->make([
            'venta_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmpleadoEsRequerido() {
        $model = factory(App\VentaMovimiento::class)->make([
            'empleado_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEstatusVentaEsRequerido() {
        $model = factory(App\VentaMovimiento::class)->make([
            'estatus_venta_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEstadoVentaEsRequerido() {
        $model = factory(App\VentaMovimiento::class)->make([
            'estado_venta_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::venta
     * @group relaciones
     */
    public function testVenta() {
        $parent = factory(App\Venta::class)->create();
        $child = factory(App\VentaMovimiento::class)->create([
            'venta_id' => $parent->id
        ]);
        $parent_result = $child->venta;
        $this->assertInstanceOf('App\Venta', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado() {
        $parent = factory(App\Empleado::class)->create();
        $child = factory(App\VentaMovimiento::class)->create([
            'empleado_id' => $parent->id
        ]);
        $parent_result = $child->empleado;
        $this->assertInstanceOf('App\Empleado', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::estatusVenta
     * @group relaciones
     */
    public function testEstatusVenta() {
        $parent = factory(App\EstatusVenta::class)->create();
        $child = factory(App\VentaMovimiento::class)->create([
            'estatus_venta_id' => $parent->id
        ]);
        $parent_result = $child->estatusVenta;
        $this->assertInstanceOf('App\EstatusVenta', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::estadoVenta
     * @group relaciones
     */
    public function testEstadoVenta() {
        DB::statement("SET foreign_key_checks=0");
        App\EstadoVenta::truncate();
        DB::statement("SET foreign_key_checks=1");
        $parent = factory(App\EstadoVenta::class)->create();
        $child = factory(App\VentaMovimiento::class)->create([
            'estado_venta_id' => $parent->id
        ]);
        $parent_result = $child->estadoVenta;
        $this->assertInstanceOf('App\EstadoVenta', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

}
