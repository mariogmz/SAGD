<?php

/**
 * @coversDefaultClass \App\TransferenciaDetalle
 */
class TransferenciaDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $td = factory(App\TransferenciaDetalle::class)->make();
        $this->assertTrue($td->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $td = factory(App\TransferenciaDetalle::class, 'full')->create();
        $td->cantidad = 1991;
        $this->assertTrue($td->isValid('update'));
        $this->assertTrue($td->save());
        $this->assertSame(1991, $td->cantidad);
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsObligatorio()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['cantidad' => null]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsEntero()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['cantidad' => 10.2]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsPositivo()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['cantidad' => -1]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaOrigenAntesEsObligatorio()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_origen_antes' => null]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaOrigenAntesEsEntero()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_origen_antes' => 10.2]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaOrigenAntesEsPositivo()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_origen_antes' => -1]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaOrigenDespuesEsObligatorio()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_origen_despues' => null]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaOrigenDespuesEsEntero()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_origen_despues' => 10.2]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaOrigenDespuesEsPositivo()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_origen_despues' => -1]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDestinoAntesEsObligatorio()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_destino_antes' => null]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDestinoAntesEsEntero()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_destino_antes' => 10.2]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDestinoAntesEsPositivo()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_destino_antes' => -1]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDestinoDespuesEsObligatorio()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_destino_despues' => null]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDestinoDespuesEsEntero()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_destino_despues' => 10.2]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExistenciaDestinoDespuesEsPositivo()
    {
        $td = factory(App\TransferenciaDetalle::class)->make(['existencia_destino_despues' => -1]);
        $this->assertFalse($td->isValid());
    }

    /**
     * @covers ::transferencia
     * @group relaciones
     */
    public function testTransferencia()
    {
        $td = factory(App\TransferenciaDetalle::class, 'full')->make();
        $transferencia = $td->transferencia;
        $this->assertInstanceOf(App\Transferencia::class, $transferencia);
    }

    /**
     * @covers ::transferencia
     * @group relaciones
     */
    public function testTransferenciaAssociate()
    {
        $td = factory(App\TransferenciaDetalle::class, 'full')->make(['transferencia_id' => null]);
        $transferencia = factory(App\Transferencia::class, 'full')->create();
        $td->transferencia()->associate($transferencia);
        $this->assertInstanceOf(App\Transferencia::class, $td->transferencia);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $td = factory(App\TransferenciaDetalle::class, 'full')->make();
        $producto = $td->producto;
        $this->assertInstanceOf(App\Producto::class, $producto);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProductoAssociate()
    {
        $td = factory(App\TransferenciaDetalle::class, 'full')->make(['producto_id' => null]);
        $producto = factory(App\Producto::class)->create();
        $td->producto()->associate($producto);
        $this->assertInstanceOf(App\Producto::class, $td->producto);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimiento()
    {
        $td = factory(App\TransferenciaDetalle::class, 'full')->make();
        $pm = $td->productoMovimiento;
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pm);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimientoAssociate()
    {
        $td = factory(App\TransferenciaDetalle::class, 'full')->make(['producto_movimiento_id' => null]);
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $td->productoMovimiento()->associate($pm);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $td->productoMovimiento);
    }
}
