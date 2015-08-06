<?php

/**
 * @coversDefaultClass \App\VentaDetalle
 */
class VentaDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testCantidadEsRequerida() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'cantidad' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoEsRequerida() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'descripcion' => ''
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoMasDe50Caracteres() {
        $model = factory(App\VentaDetalle::class, 'descripcionlarga')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPrecioEsRequerido() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'precio' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPrecioEsDecimal() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'precio' => 'IBelieveICanFly'
        ]);
        $this->assertFalse($model->isValid());
        $model->precio = 1000.50;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTotalEsRequerido() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'total' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTotalEsDecimal() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'total' => 'GoodToSeeYouMrAnderson'
        ]);
        $this->assertFalse($model->isValid());
        $model->total = 1000.00;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTotalEsIgualACantidadPorPrecio() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'cantidad' => 2,
            'precio'   => 3.50,
            'total'    => 4
        ]);
        $this->assertFalse($model->save());
        $model->total = $model->cantidad * $model->precio;
        $this->assertTrue($model->save());
    }

    /**
     * @coversNothing
     */
    public function testUtilidadEsRequerida() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'utilidad' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUtilidadEsDecimal() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'utilidad' => 'FusRoDah'
        ]);
        $this->assertFalse($model->isValid());
        $model->utilidad = 10.00;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpiracionGarantiaNoEsRequerido() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'fecha_expiracion_garantia' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTiempoGarantiaEsRequerido() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'tiempo_garantia' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTiempoGarantiaEsNumerico() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'tiempo_garantia' => 'ChoosenOne'
        ]);
        $this->assertFalse($model->isValid());
        $model->tiempo_garantia = 30;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTiempoGarantiaEsPositivo() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'tiempo_garantia' => - 10
        ]);
        $this->assertFalse($model->isValid());
        $model->tiempo_garantia = 30;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testVentaEsRequerido() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'venta_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoPartidaEsRequerido() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'tipo_partida_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMetodoPagoDebeSerVacioSiNoEsProducto() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'producto_id'    => null,
            'metodo_pago_id' => factory(App\MetodoPago::class)->create()->id,
        ]);
        $this->assertFalse($model->save());
        $model->metodo_pago_id = null;
        $this->assertTrue($model->save());
    }

    /**
     * @coversNothing
     */
    public function testProductoNoEsRequerido() {
        $model = factory(App\VentaDetalle::class, 'pago')->make();
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMetodoPagoNoEsRequerido() {
        $model = factory(App\VentaDetalle::class, 'producto')->make();
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFacturaNoEsRequerida() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'factura_id' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNotaCreditoNoEsRequerida() {
        $model = factory(App\VentaDetalle::class, 'producto')->make([
            'nota_credito_id' => null
        ]);
        $this->assertTrue($model->isValid());
    }

}
