<?php

/**
 * @coversDefaultClass \App\Venta
 */
class VentaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testTieneTimestamps() {
        $model = factory(App\Venta::class)->make();
        if ($model->save()) {
            $this->assertNotEmpty($model->created_at);
            $model->touch(); // Update the model's update timestamp
            $this->assertNotEmpty($model->updated_at);
        } else {
            $this->assertTrue($model->timestamps);
        }
    }

    /**
     * @coversNothing
     */
    public function testTotalNoEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'total' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTotalEsDecimal() {
        $model = factory(App\Venta::class)->make([
            'total' => 'MasterOfPuppets'
        ]);
        $this->assertFalse($model->isValid(), 'Venta no es valida cuando el total no es decimal');
        $model->total = 1000.00;
        $model->pago = $model->total;
        $this->assertTrue($model->isValid(), 'Venta es valida cuando el total es decimal');
    }

    /**
     * @coversNothing
     */
    public function testPagoNoEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'pago' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testpagoEsDecimal() {
        $model = factory(App\Venta::class)->make([
            'pago' => 'HotelCalifornia'
        ]);
        $this->assertFalse($model->isValid());
        $model->pago = 2000.00;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPagoDebeSerMayorATotal() {
        $model = factory(App\Venta::class)->make([
            'total' => 10.50,
            'pago'  => 10.00
        ]);
        $this->assertFalse($model->isValid());
        $model->pago = 11.00;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUtilidadNoEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'utilidad' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUtilidadDebeSerMayorACero() {
        $model = factory(App\Venta::class)->make([
            'utilidad' => - 10.00
        ]);
        $this->assertFalse($model->isValid());
        $this->utilidad = 0.00;
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUtilidadEsDecimal() {
        $model = factory(App\Venta::class)->make([
            'utilidad' => 'BohemianRhapsody'
        ]);
        $this->assertFalse($model->isValid());
        $model->utilidad = 500.00;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaDeCobroNoEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'fecha_cobro' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTabuladorNoEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'tabulador' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTabuladorEsUnEnteroDel1Al10() {
        $model = factory(App\Venta::class)->make([
            'tabulador' => 30
        ]);
        $this->assertFalse($model->isValid());
        for ($i = 0; $i <= 10; $i ++) {
            $model->tabulador = $i;
            if (!$i) $this->assertFalse($model->isValid());
            else        $this->assertTrue($model->isValid());
        }
    }

    /**
     * @coversNothing
     */
    public function testSucursalEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'sucursal_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClienteEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'cliente_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCajaEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'caja_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCorteNoEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'corte_id' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEstatusVentaEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'estatus_venta_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEstadoVentaEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'estado_venta_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoVentaEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'tipo_venta_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalEntregaEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'sucursal_entrega_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmpleadoNoEsRequerido() {
        $model = factory(App\Venta::class)->make([
            'empleado_id' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal() {
        $parent = factory(App\Sucursal::class)->create();
        $child = factory(App\Venta::class)->create([
            'sucursal_id' => $parent->id
        ]);
        $parent_result = $child->sucursal;
        $this->assertInstanceOf('App\Sucursal', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::cliente
     * @group relaciones
     */
    public function testCliente() {
        $parent = factory(App\Cliente::class, 'full')->create();
        $child = factory(App\Venta::class)->create([
            'cliente_id' => $parent->id
        ]);
        $parent_result = $child->cliente;
        $this->assertInstanceOf('App\Cliente', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::caja
     * @group relaciones
     */
    public function testCaja() {
        $parent = factory(App\Caja::class)->create();
        $child = factory(App\Venta::class)->create([
            'caja_id' => $parent->id
        ]);
        $parent_result = $child->caja;
        $this->assertInstanceOf('App\Caja', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::corte
     * @group relaciones
     */
    public function testCorte() {
        $parent = factory(App\Corte::class)->create();
        $child = factory(App\Venta::class)->create([
            'corte_id' => $parent->id
        ]);
        $parent_result = $child->corte;
        $this->assertInstanceOf('App\Corte', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::estatusVenta
     * @group relaciones
     */
    public function testEstatusVenta() {
        $parent = factory(App\EstatusVenta::class)->create();
        $child = factory(App\Venta::class)->create([
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
        $parent = factory(App\EstadoVenta::class)->create();
        $child = factory(App\Venta::class)->create([
            'estado_venta_id' => $parent->id
        ]);
        $parent_result = $child->estadoVenta;
        $this->assertInstanceOf('App\EstadoVenta', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::tipoVenta
     * @group relaciones
     */
    public function testTipoVenta() {
        $parent = factory(App\TipoVenta::class)->create();
        $child = factory(App\Venta::class)->create([
            'tipo_venta_id' => $parent->id
        ]);
        $parent_result = $child->tipoVenta;
        $this->assertInstanceOf('App\TipoVenta', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::sucursalEntrega
     * @group relaciones
     */
    public function testSucursalEntrega() {
        $parent = factory(App\Sucursal::class)->create();
        $child = factory(App\Venta::class)->create([
            'sucursal_entrega_id' => $parent->id
        ]);
        $parent_result = $child->sucursalEntrega;
        $this->assertInstanceOf('App\Sucursal', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado() {
        $parent = factory(App\Empleado::class)->create();
        $child = factory(App\Venta::class)->create([
            'empleado_id' => $parent->id
        ]);
        $parent_result = $child->empleado;
        $this->assertInstanceOf('App\Empleado', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::ventasDetalles
     * @group relaciones
     */
    public function testVentasDetalles() {
        $parent = factory(App\Venta::class)->create();
        factory(App\VentaDetalle::class, 'producto')->create([
            'venta_id' => $parent->id
        ]);
        $children = $parent->ventasDetalles;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\VentaDetalle', $children[0]);
        $this->assertCount(1, $children);
    }

    /**
     * @covers ::anticipos
     * @group relaciones
     */
    public function testAnticipos() {
        $parent = factory(App\Venta::class, 'cobrada')->create();
        factory(App\Anticipo::class)->create([
            'venta_id' => $parent->id
        ]);
        $children = $parent->anticipos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Anticipo', $children[0]);
        $this->assertCount(1, $children);
    }

    /**
     * @covers ::anticiposEntrega
     * @group relaciones
     */
    public function testAnticiposEntrega() {
        $parent = factory(App\Venta::class, 'cobrada')->create();
        factory(App\Anticipo::class)->create([
            'venta_entrega_id' => $parent->id
        ]);
        $children = $parent->anticiposEntrega;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Anticipo', $children[0]);
        $this->assertCount(1, $children);
    }

    /**
     * @covers ::ventasMovimientos
     * @group relaciones
     */
    public function testVentasMovimientos() {
        $parent = factory(App\Venta::class)->create();
        factory(App\VentaMovimiento::class)->create([
            'venta_id' => $parent->id
        ]);
        $children = $parent->ventasMovimientos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\VentaMovimiento', $children[0]);
        $this->assertCount(1, $children);
    }

}
