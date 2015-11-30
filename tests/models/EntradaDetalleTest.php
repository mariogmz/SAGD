<?php

/**
 * @coversDefaultClass \App\EntradaDetalle
 */
class EntradaDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $ed = factory(App\EntradaDetalle::class)->make();
        $this->assertTrue($ed->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->create();
        $ed->costo = 1991.0;
        $ed->importe = $ed->costo * $ed->cantidad;
        $this->assertTrue($ed->isValid('update'));
        $this->assertTrue($ed->save());
        $this->assertSame(1991.0, $ed->costo);
    }

    /**
     * @coversNothing
     */
    public function testCostoEsObligatorio()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['costo' => null]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoTieneQueSerPositivo()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['costo' => -1.0]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoTieneQueSerDecimal()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['costo' => 'a']);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsObligatorio()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['cantidad' => null]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsPositivo()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['cantidad' => -1]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsEntero()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['cantidad' => 'a']);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testImporteEsObligatorio()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['importe' => null]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testImporteEsPositivo()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['importe' => -1.0]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testImporteEsDecimal()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['importe' => 'a']);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testImporteEsCostoPorCantidad()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['importe' => 1.0]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @covers ::entrada
     * @group relaciones
     */
    public function testEntrada()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->make();
        $entrada = $ed->entrada;
        $this->assertInstanceOf(App\Entrada::class, $entrada);
    }

    /**
     * @covers ::entrada
     * @group relaciones
     */
    public function testEntradaAssociate()
    {
        $ed = factory(App\EntradaDetalle::class, 'noentrada')->make();
        $entrada = factory(App\Entrada::class, 'full')->create();
        $ed->entrada()->associate($entrada);
        $ed->save();
        $this->assertInstanceOf(App\Entrada::class, $ed->entrada);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->make();
        $producto = $ed->producto;
        $this->assertInstanceOf(App\Producto::class, $producto);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProductoAssociate()
    {
        $ed = factory(App\EntradaDetalle::class, 'noproducto')->make();
        $producto = factory(App\Producto::class)->create();
        $ed->producto()->associate($producto);
        $ed->save();
        $this->assertInstanceOf(App\Producto::class, $ed->producto);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimiento()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->make();
        $pm = $ed->productoMovimiento;
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pm);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimientoAssociate()
    {
        $ed = factory(App\EntradaDetalle::class, 'noproductomovimiento')->make();
        $producto = $ed->producto;
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $ed->productoMovimiento()->associate($pm);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $ed->productoMovimiento);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargar()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $this->assertTrue($detalle->cargar());
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargarInvalido()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $this->mock = Mockery::mock('App\Listeners\CrearProductoMovimientoDesdeEntrada');
        $this->mock->shouldReceive([
            'handle' => [false]
        ])->withAnyArgs();
        $this->app->instance('App\Listeners\CrearProductoMovimientoDesdeEntrada', $this->mock);

        $this->assertFalse($detalle->cargar());
    }

    /**
     * @covers ::recalcularImporte
     * @group feature-entradas
     */
    public function testRecalcularImporte()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $detalle->cantidad = 10;
        $detalle->recalcularImporte();

        $this->assertEquals(10.0, $detalle->importe);
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

    private function setUpEntrada()
    {
        $this->setUpEstados();
        $producto = App\Producto::last();
        $sucursal = App\Sucursal::last();


        $entrada = new App\Entrada([
            'factura_externa_numero' => 'ABDC-1234-XXXX',
            'moneda' => 'PESOS',
            'tipo_cambio' => 1.00,
            'estado_entrada_id' => App\EstadoEntrada::creando()->id,
            'proveedor_id' => $sucursal->proveedor_id,
            'empleado_id' => factory(App\Empleado::class)->create(['sucursal_id' => $sucursal->id])->id,
            'razon_social_id' => factory(App\RazonSocialEmisor::class, 'full')->create()->id
        ]);
        $entrada->save();
        return $entrada;
    }

    private function setUpDetalle($cantidad = 5, $costo = 1.0, $importe = null)
    {
        $producto = App\Producto::last();
        $sucursal = App\Sucursal::last();
        $entrada = App\Entrada::last();
        $importe = $cantidad * $costo;

        $detalle = [
            'costo' => $costo,
            'cantidad' => $cantidad,
            'importe' => $importe,
            'producto_id' => $producto->id,
            'sucursal_id' => $sucursal->id,
            'upc' => $producto->upc
        ];
        return $entrada->crearDetalle($detalle);
    }

    private function setUpEstados()
    {
        $estadoEntradaCreando = new App\EstadoEntrada(['nombre' => 'Creando']);
        $estadoEntradaCargando = new App\EstadoEntrada(['nombre' => 'Cargando']);
        $estadoEntradaCargado = new App\EstadoEntrada(['nombre' => 'Cargado']);

        $estadoEntradaCreando->save();
        $estadoEntradaCargando->save();
        $estadoEntradaCargado->save();
    }
}
