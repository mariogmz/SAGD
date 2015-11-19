<?php

/**
 * @coversDefaultClass \App\SalidaDetalle
 */
class SalidaDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $sd = factory(App\SalidaDetalle::class)->make();
        $this->assertTrue($sd->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $sd = factory(App\SalidaDetalle::class, 'full')->create();
        $sd->cantidad = 1991;
        $this->assertTrue($sd->isValid('update'));
        $this->assertTrue($sd->save());
        $this->assertSame(1991, $sd->cantidad);
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsObligatorio()
    {
        $sd = factory(App\SalidaDetalle::class)->make(['cantidad' => null]);
        $this->assertFalse($sd->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadTieneQueSerEntero()
    {
        $sd = factory(App\SalidaDetalle::class)->make(['cantidad' => 1991.5]);
        $this->assertFalse($sd->isValid());
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $sd = factory(App\SalidaDetalle::class, 'full')->make();
        $producto = $sd->producto;
        $this->assertInstanceOf(App\Producto::class, $producto);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProductoAssociate()
    {
        $sd = factory(App\SalidaDetalle::class, 'noproducto')->make();
        $producto = factory(App\Producto::class)->create();
        $sd->producto()->associate($producto);
        $this->assertInstanceOf(App\Producto::class, $sd->producto);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimiento()
    {
        $sd = factory(App\SalidaDetalle::class, 'full')->make();
        $pm = $sd->productoMovimiento;
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pm);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimientoAssociate()
    {
        $sd = factory(App\SalidaDetalle::class, 'noproductomovimiento')->make();
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $sd->productoMovimiento()->associate($pm);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $sd->productoMovimiento);
    }

    /**
     * @covers ::salida
     * @group relaciones
     */
    public function testSalida()
    {
        $sd = factory(App\SalidaDetalle::class, 'full')->make();
        $salida = $sd->salida;
        $this->assertInstanceOf(App\Salida::class, $salida);
    }

    /**
     * @covers ::salida
     * @group relaciones
     */
    public function testSalidaAssociate()
    {
        $sd = factory(App\SalidaDetalle::class, 'nosalida')->make();
        $salida = factory(App\Salida::class, 'full')->create();
        $sd->salida()->associate($salida);
        $this->assertInstanceOf(App\Salida::class, $sd->salida);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargar()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $this->assertTrue($detalle->cargar());
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarInvalido()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $this->mock = Mockery::mock('App\Listeners\CrearProductoMovimientoDesdeSalida');
        $this->mock->shouldReceive([
            'handle' => [false]
        ])->withAnyArgs();
        $this->app->instance('App\Listeners\CrearProductoMovimientoDesdeSalida', $this->mock);

        $this->assertFalse($detalle->cargar());
    }

    private function setUpProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);

        $productoSucursal = $producto->productosSucursales()->where('sucursal_id', $sucursal->id)->first();
        $productoSucursal->existencia()->create([
            'cantidad' => 100,
            'cantidad_apartado' => 0,
            'cantidad_pretransferencia' => 0,
            'cantidad_transferencia' => 0,
            'cantidad_garantia_cliente' => 0,
            'cantidad_garantia_zegucom' => 0
        ]);
        return $producto;
    }

    private function setUpSalida()
    {
        $producto = App\Producto::last();
        $sucursal = App\Sucursal::last();

        $salida = new App\Salida([
            'motivo' => 'Test',
            'empleado_id' => factory(App\Empleado::class)->create(['sucursal_id' => $sucursal->id])->id,
            'estado_salida_id' => factory(App\EstadoSalida::class)->create()->id,
            'sucursal_id' => $sucursal->id
        ]);
        $salida->save();
        return $salida;
    }

    private function setUpDetalle()
    {
        $producto = App\Producto::last();
        $salida = App\Salida::last();

        $detalle = [
            'cantidad' => 5,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];

        return $salida->crearDetalle($detalle);
    }
}
