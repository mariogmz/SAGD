<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\Entrada
 */
class EntradaTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $entrada = factory(App\Entrada::class)->make();
        $this->assertTrue($entrada->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $entrada = factory(App\Entrada::class, 'full')->create();
        $entrada->moneda = 'MC Hammer';
        $this->assertTrue($entrada->isValid('update'));
        $this->assertTrue($entrada->save());
        $this->assertSame('MC Hammer', $entrada->moneda);
    }

    /**
     * @coversNothing
     */
    public function testFacturaExternaNumeroEsObligatorio()
    {
        $entrada = factory(App\Entrada::class)->make(['factura_externa_numero' => null]);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFacturaExternaNumeroNoPuedeSerLargo()
    {
        $entrada = factory(App\Entrada::class, 'longfen')->make();
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFacturaFechaNoEsObligatorio()
    {
        $entrada = factory(App\Entrada::class)->make(['factura_fecha' => null]);
        $this->assertTrue($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFacturaFechaEsTimestamp()
    {
        $entrada = factory(App\Entrada::class)->make(['factura_fecha' => 'a']);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMonedaEsObligatorio()
    {
        $entrada = factory(App\Entrada::class)->make(['moneda' => null]);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMonedaNoPuedeSerLarga()
    {
        $entrada = factory(App\Entrada::class, 'longmoneda')->make();
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoDeCambioEsObligatorio()
    {
        $entrada = factory(App\Entrada::class)->make(['tipo_cambio' => null]);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoDeCambioEsDecimal()
    {
        $entrada = factory(App\Entrada::class)->make(['tipo_cambio' => 'a']);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $estado = $entrada->estado;
        $this->assertInstanceOf(App\EstadoEntrada::class, $estado);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $entrada = factory(App\Entrada::class, 'noestado')->make(['estado_entrada_id' => null]);
        $estado = factory(App\EstadoEntrada::class)->create();
        $entrada->estado()->associate($estado);
        $entrada->save();
        $this->assertInstanceOf(App\EstadoEntrada::class, $entrada->estado);
        $this->assertSame(1, count($entrada->estado));
    }

    /**
     * @covers ::proveedor
     * @group relaciones
     */
    public function testProveedor()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $proveedor = $entrada->proveedor;
        $this->assertInstanceOf(App\Proveedor::class, $proveedor);
    }

    /**
     * @covers ::proveedor
     * @group relaciones
     */
    public function testProveedorAssociate()
    {
        $entrada = factory(App\Entrada::class, 'noproveedor')->make();
        $proveedor = factory(App\Proveedor::class)->create();
        $entrada->proveedor()->associate($proveedor);
        $entrada->save();
        $this->assertInstanceOf(App\Proveedor::class, $entrada->proveedor);
        $this->assertSame(1, count($entrada->proveedor));
    }

    /**
     * @covers ::razonSocial
     * @group relaciones
     */
    public function testRazonSocial()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $rse = $entrada->razonSocial;
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $rse);
    }

    /**
     * @covers ::razonSocial
     * @group relaciones
     */
    public function testRazonSocialAssociate()
    {
        $entrada = factory(App\Entrada::class, 'norazonsocial')->make();
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create();
        $entrada->razonSocial()->associate($rse);
        $entrada->save();
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $entrada->razonSocial);
        $this->assertSame(1, count($entrada->razonSocial));
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $empleado = $entrada->empleado;
        $this->assertInstanceOf(App\Empleado::class, $empleado);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleadoAssociate()
    {
        $entrada = factory(App\Entrada::class, 'noempleado')->make();
        $empleado = factory(App\Empleado::class)->create();
        $entrada->empleado()->associate($empleado);
        $entrada->save();
        $this->assertInstanceOf(App\Empleado::class, $entrada->empleado);
        $this->assertSame(1, count($entrada->empleado));
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $sucursal = $entrada->sucursal;
        $this->assertInstanceOf(App\Sucursal::class, $sucursal);
    }

    /**
     * @covers ::detalles
     * @group relaciones
     */
    public function testDetalles()
    {
        $entrada = factory(App\Entrada::class, 'full')->create();
        $ed = factory(App\EntradaDetalle::class, 'full')->create(['entrada_id' => $entrada->id]);
        $detalles = $entrada->detalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $detalles);
        $this->assertInstanceOf(App\EntradaDetalle::class, $detalles[0]);
        $this->assertCount(1, $detalles);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-entradas
     */
    public function testCrearDetalleConParametrosDeDetalleEsExitoso()
    {
        $producto = $this->setUpProducto();
        $sucursal = App\Sucursal::last();
        $entrada = $this->setUpEntrada();
        $detalle = [
            'costo' => 1.0,
            'cantidad' => 1,
            'importe' => 1.0,
            'producto_id' => $producto->id,
            'sucursal_id' => $sucursal->id,
            'upc' => $producto->upc
        ];

        $this->assertInstanceOf(App\EntradaDetalle::class, $entrada->crearDetalle($detalle));
    }

    /**
     * @covers ::crearDetalle
     * @group feature-entradas
     */
    public function testCrearDetalleConParametroIncorrectoNoEsExitoso()
    {
        $producto = $this->setUpProducto();
        $sucursal = App\Sucursal::last();
        $entrada = $this->setUpEntrada();
        $detalle = [
            'costo' => 1.0,
            'cantidad' => -1,
            'importe' => 1.0,
            'producto_id' => $producto->id,
            'sucursal_id' => $sucursal->id,
            'upc' => $producto->upc
        ];

        $this->assertFalse($entrada->crearDetalle($detalle));
    }

    /**
     * @covers ::crearDetalle
     * @group feature-entradas
     */
    public function testCrearDetalleConParametrosFaltantesNoExitoso()
    {
        $producto = $this->setUpProducto();
        $sucursal = App\Sucursal::last();
        $entrada = $this->setUpEntrada();
        $detalle = [
            'costo' => 1.0,
            'importe' => 1.0,
            'producto_id' => $producto->id,
            'sucursal_id' => $sucursal->id,
            'upc' => $producto->upc
        ];

        $this->assertFalse($entrada->crearDetalle($detalle));
    }

    /**
     * @covers ::quitarDetalle
     * @group feature-entradas
     */
    public function testQuitarDetalleConDetalleCorrectoEsExitoso()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $this->setUpDetalle();

        $detalle = App\EntradaDetalle::last()->id;

        $this->assertTrue($entrada->quitarDetalle($detalle));
    }

    /**
     * @covers ::quitarDetalle
     * @group feature-entradas
     */
    public function testQuitarDetalleConDetalleIncorrectoNoEsExitoso()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $this->setUpDetalle();

        $detalle = App\EntradaDetalle::last()->id + 1;

        $this->assertFalse($entrada->quitarDetalle($detalle));
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargarExitoso()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $this->assertTrue($entrada->cargar());
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargarCreaProductosMovimientos()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $movimientos = App\ProductoMovimiento::count();
        $entrada->cargar();

        $this->assertGreaterThan($movimientos, App\ProductoMovimiento::count());
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargarActualizaLasExistenciasDelProducto()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $entrada->cargar();
        $existencia = $producto->existencias(App\Sucursal::last());
        $this->assertEquals(105, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargarMultiplesvecesActualizaLasExistenciasDelProducto()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        for ($i=0; $i < 10; $i++) {
            $this->setUpDetalle();
        }

        $entrada->cargar();
        $existencia = $producto->existencias(App\Sucursal::last());
        $this->assertEquals(150, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargarEstableceBienLasExistenciasAnteriores()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $entrada->cargar();
        $pm = $producto->movimientos(App\Sucursal::last())->last();

        $this->assertEquals(100, $pm->existencias_antes);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargarEstableceBienLasExistenciasPosteriores()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $entrada->cargar();
        $pm = $producto->movimientos(App\Sucursal::last())->last();

        $this->assertEquals(105, $pm->existencias_despues);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testTodosLosDetallesTienenUnProductoMovimientoDespuesDeLaCarga()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $entrada->cargar();
        $detalle = $entrada->detalles()->first();

        $this->assertInstanceOf(App\ProductoMovimiento::class, $detalle->productoMovimiento);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     * @group feature-entradas-rollback
     */
    public function testCargarCuandoActualizarExistenciasFallaLasExistenciasPermanecenIntactas()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $this->mock = Mockery::mock('App\Listeners\ActualizarExistencias');
        $this->mock->shouldReceive([
            'handle' => ['success' => false]
        ]);
        $this->app->instance('App\Listeners\ActualizarExistencias', $this->mock);

        $entrada->cargar();
        $existencia = $producto->existencias(App\Sucursal::last());

        $this->assertEquals(100, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     * @group feature-entradas-rollback
     */
    public function testCargarRollbackVerificarExistencias()
    {
        $firstProduct = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $this->setUpDetalle();

        $producto = factory(App\Producto::class)->create();
        $sucursal = App\Sucursal::last();
        $productoSucursal = $producto->productosSucursales()->where('sucursal_id', $sucursal->id)->first();
        $productoSucursal->existencia()->create([
            'cantidad' => 100,
            'cantidad_apartado' => 0,
            'cantidad_pretransferencia' => 0,
            'cantidad_transferencia' => 0,
            'cantidad_garantia_cliente' => 0,
            'cantidad_garantia_zegucom' => 0
        ]);

        $detalle = [
            'costo' => 1.0,
            'cantidad' => 5,
            'importe' => 5.0,
            'producto_id' => $producto->id,
            'sucursal_id' => $sucursal->id,
            'upc' => $producto->upc
        ];
        $entrada->crearDetalle($detalle);

        $this->mock = Mockery::mock('App\Listeners\ActualizarExistencias');
        $this->mock->shouldReceive('handle')->twice()->withAnyArgs()->andReturn(
            ['success' => true, 'antes' => 100, 'despues' => 105],
            ['success' => false]
        );
        $this->app->instance('App\Listeners\ActualizarExistencias', $this->mock);

        $entrada->cargar();
        $existencia = $firstProduct->existencias($sucursal);

        $this->assertEquals(100, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testCargarActualizaElEstadoDeLaEntrada()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $estado = $entrada->estado_entrada_id;
        $entrada->cargar();
        $entrada = $entrada->fresh();

        $this->assertFalse($estado === $entrada->estado_entrada_id);
    }

    /**
     * @covers ::cargar
     * @group feature-entradas
     */
    public function testEntradaSoloPuedeSerCargadaUnaVez()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $detalle = $this->setUpDetalle();

        $this->assertTrue($entrada->cargar());
        $this->assertFalse($entrada->cargar());
    }

    /**
     * @covers ::crearDetalle
     * @group feature-entradas
     */
    public function testCargarDosVecesUnDetalleConMismoUpcLoAgrupaEnUnSoloDetalle()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        $this->setUpDetalle();
        $this->setUpDetalle();

        $this->assertCount(1, $entrada->detalles);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-entradas
     */
    public function testCargarMismoDetalleActualizaCorrectamenteLaCantidad()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        for ($i=0; $i < 5; $i++) {
            $this->setUpDetalle();
        }

        $this->assertEquals(25, $entrada->detalles()->first()->cantidad);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-entradas
     */
    public function testCargarMismoDetalleVariasVecesActualizarCorrectamenteExistencias()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        for ($i=0; $i < 5; $i++) {
            $this->setUpDetalle();
        }

        $entrada->cargar();
        $existencia = $producto->existencias(App\Sucursal::last());

        $this->assertEquals(125, $existencia->cantidad);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-entradas
     */
    public function testCargarMismoDetalleVariasVecesSoloCreaUnProductoMovimiento()
    {
        $producto = $this->setUpProducto();
        $entrada = $this->setUpEntrada();
        for ($i=0; $i < 5; $i++) {
            $this->setUpDetalle();
        }

        $entrada->cargar();
        $movimientos = $producto->movimientos->count();

        $this->assertEquals(1, $movimientos);
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
            'razon_social_id' => factory(App\RazonSocialEmisor::class, 'full')->create()->id,
            'empleado_id' => factory(App\Empleado::class)->create(['sucursal_id' => $sucursal->id])->id,
            'sucursal_id' => $sucursal->id
        ]);
        $entrada->save();
        return $entrada;
    }

    private function setUpDetalle($cantidad = 5, $costo = 1.0, $importe = null)
    {
        $producto = App\Producto::last();
        $sucursal = App\Sucursal::last();
        $entrada = App\Entrada::last();

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
