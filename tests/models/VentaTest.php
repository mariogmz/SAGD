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
        // TODO: There's something to fix in here
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
    public function testTabuladorEsUnEnterodel1Al10() {
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

}
