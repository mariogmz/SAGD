<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\Transferencia
 */
class TransferenciaTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $transferencia = factory(App\Transferencia::class)->make();
        $this->assertTrue($transferencia->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->create();
        $date = Carbon\Carbon::now()->addDay();
        $transferencia->fecha_recepcion = $date;
        $this->assertTrue($transferencia->isValid('update'));
        $this->assertTrue($transferencia->save());
        $this->assertSame($date, $transferencia->fecha_recepcion);
    }

    /**
     * @coversNothing
     */
    public function testFechaTransferenciaEsOpcional()
    {
        $transferencia = factory(App\Transferencia::class)->make(['fecha_transferencia' => null]);
        $this->assertTrue($transferencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaTransferenciaEsTimestamp()
    {
        $transferencia = factory(App\Transferencia::class)->make(['fecha_transferencia' => 'a']);
        $this->assertFalse($transferencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaRecepcionEsOpcional()
    {
        $transferencia = factory(App\Transferencia::class)->make(['fecha_recepcion' => null]);
        $this->assertTrue($transferencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaRecepcionEsTimestamp()
    {
        $transferencia = factory(App\Transferencia::class)->make(['fecha_recepcion' => 'a']);
        $this->assertFalse($transferencia->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEstadoTransferenciaPuedeSerNulo()
    {
        $this->setUpEstados();
        $transferencia = factory(App\Transferencia::class, 'full')->make(['estado_transferencia_id' => null]);
        $this->assertTrue($transferencia->isValid());
        $this->assertTrue($transferencia->save());
    }

    /**
     * @coversNothing
     */
    public function testEmpleadoRevisionPuedeSerNulo()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make(['empleado_revision_id' => null]);
        $this->assertTrue($transferencia->isValid());
        $this->assertTrue($transferencia->save());
    }

    /**
     * @coversNothing
     */
    public function testEmpleadoDestinoPuedeSerNulo()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make(['empleado_destino_id' => null]);
        $this->assertTrue($transferencia->isValid());
        $this->assertTrue($transferencia->save());
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make();
        $et = $transferencia->estado;
        $this->assertInstanceOf(App\EstadoTransferencia::class, $et);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make(['estado_transferencia_id' => null]);
        $et = factory(App\EstadoTransferencia::class)->create();
        $transferencia->estado()->associate($et);
        $this->assertInstanceOf(App\EstadoTransferencia::class, $transferencia->estado);
    }

    /**
     * @covers ::sucursalOrigen
     * @group relaciones
     */
    public function testSucursalOrigen()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make();
        $so = $transferencia->sucursalOrigen;
        $this->assertInstanceOf(App\Sucursal::class, $so);
    }

    /**
     * @covers ::sucursalOrigen
     * @group relaciones
     */
    public function testSucursalOrigenAssociate()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make(['sucursal_origen_id' => null]);
        $sucursal = factory(App\Sucursal::class)->create();
        $transferencia->sucursalOrigen()->associate($sucursal);
        $this->assertInstanceOf(App\Sucursal::class, $transferencia->sucursalOrigen);
    }

    /**
     * @covers ::sucursalDestino
     * @group relaciones
     */
    public function testSucursalDestino()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make();
        $sd = $transferencia->sucursalDestino;
        $this->assertInstanceOf(App\Sucursal::class, $sd);
    }

    /**
     * @covers ::sucursalDestino
     * @group relaciones
     */
    public function testSucursalDestinoAssociate()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make(['sucursal_destino_id' => null]);
        $sucursal = factory(App\Sucursal::class)->create();
        $transferencia->sucursalDestino()->associate($sucursal);
        $this->assertInstanceOf(App\Sucursal::class, $transferencia->sucursalDestino);
    }

    /**
     * @covers ::empleadoOrigen
     * @group relaciones
     */
    public function testEmpleadoOrigen()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make();
        $eo = $transferencia->empleadoOrigen;
        $this->assertInstanceOf(App\Empleado::class, $eo);
    }

    /**
     * @covers ::empleadoOrigen
     * @group relaciones
     */
    public function testEmpleadoOrigenAssociate()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make(['empleado_origen_id' => null]);
        $empleado = factory(App\Empleado::class)->create();
        $transferencia->empleadoOrigen()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $transferencia->empleadoOrigen);
    }

    /**
     * @covers ::empleadoDestino
     * @group relaciones
     */
    public function testEmpleadoDestino()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make();
        $ed = $transferencia->empleadoDestino;
        $this->assertInstanceOf(App\Empleado::class, $ed);
    }

    /**
     * @covers ::empleadoDestino
     * @group relaciones
     */
    public function testEmpleadoDestinoAssociate()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make(['empleado_destino_id' => null]);
        $empleado = factory(App\Empleado::class)->create();
        $transferencia->empleadoDestino()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $transferencia->empleadoDestino);
    }

    /**
     * @covers ::empleadoRevision
     * @group relaciones
     */
    public function testEmpleadoRevision()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make();
        $er = $transferencia->empleadoRevision;
        $this->assertInstanceOf(App\Empleado::class, $er);
    }

    /**
     * @covers ::empleadoRevision
     * @group relaciones
     */
    public function testEmpleadoRevisionAssociate()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->make(['empleado_revision_id' => null]);
        $empleado = factory(App\Empleado::class)->create();
        $transferencia->empleadoRevision()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $transferencia->empleadoRevision);
    }

    /**
     * @covers ::detalles
     * @group relaciones
     */
    public function testDetalles()
    {
        $transferencia = factory(App\Transferencia::class, 'full')->create();
        $td = factory(App\TransferenciaDetalle::class, 'full')->create([
            'transferencia_id' => $transferencia->id]);
        $tds = $transferencia->detalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $tds);
        $this->assertInstanceOf(App\TransferenciaDetalle::class, $tds[0]);
        $this->assertCount(1, $tds);
    }

    /**
     * @covers ::agregarDetalle
     * @group feature-transferencias
     */
    public function testAgregarDetallesConParametrosCorrectosEsExitoso()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $detalle = [
            'cantidad' => 5,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];

        $this->assertInstanceOf(App\TransferenciaDetalle::class, $transferencia->agregarDetalle($detalle));
    }

    /**
     * @covers ::agregarDetalle
     * @group feature-transferencias
     */
    public function testAgregarDetalleConParametrosIncorrectosNoEsExitoso()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $detalle = [
            'cantidad' => 5,
            'upc' => $producto->upc
        ];

        $this->assertFalse($transferencia->agregarDetalle($detalle));
    }

    /**
     * @covers ::quitarDetalle
     * @group feature-transferencias
     */
    public function testQuitarDetalleConDetalleCorrectoEsExitoso()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();

        $detalle_id = App\TransferenciaDetalle::last()->id;

        $this->assertTrue($transferencia->quitarDetalle($detalle_id));
    }

    /**
     * @covers ::quitarDetalle
     * @group feature-transferencias
     */
    public function testQuitarDetalleConDetalleIncorrectoFalla()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();

        $detalle_id = App\TransferenciaDetalle::last()->id + 1;

        $this->assertFalse($transferencia->quitarDetalle($detalle_id));
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testTransferirEsExitoso()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();

        $this->assertTrue($transferencia->transferir());
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testTransferirActualizaElEstadoAEnTransferencia()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $this->assertEquals($transferencia->estado->id, App\EstadoTransferencia::enTransferencia());
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testTransferirCreaUnProductoMovimiento()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();

        $productosMovimientosAntes = App\ProductoMovimiento::count();

        $transferencia->transferir();

        $productosMovimientosDespues = App\ProductoMovimiento::count();

        $this->assertGreaterThan($productosMovimientosAntes, $productosMovimientosDespues);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testProductoMovimientoDeTranferirTieneMovimientoDeTransferencia()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $productoMovimiento = $producto->movimientos($producto->sucursales->first())->first();

        $this->assertEquals("Transferencia {$transferencia->id}", $productoMovimiento->movimiento);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testProductoMovimientoDeTransferirEstableceCeroEntraron()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $productoMovimiento = $producto->movimientos($producto->sucursales->first())->first();

        $this->assertEquals(0, $productoMovimiento->entraron);
    }

    /**
     * @covers ::transferir
     * @group feaute-transferencias
     */
    public function testProductoMovimientoDeTransferirEstableceCorrectamenteSalieron()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $productoMovimiento = $producto->movimientos($producto->sucursales->first())->first();

        $this->assertEquals(5, $productoMovimiento->salieron);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testProductoMovimientoDeTransferirEstableceCorrectamenteExistenciasAntes()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $productoMovimiento = $producto->movimientos($producto->sucursales->first())->first();

        $this->assertEquals(100, $productoMovimiento->existencias_antes);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testProductoMovimientoDeTransferirEstableceCorrecatementeExistenciasDespues()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $productoMovimiento = $producto->movimientos($producto->sucursales->first())->first();

        $this->assertEquals(95, $productoMovimiento->existencias_despues);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testExistenciasCantidadOrigenPermaneceIntacto()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $existencia = App\ProductoSucursal::where('producto_id', $producto->id)
            ->where('sucursal_id', $transferencia->sucursal_origen_id)->first()->existencia()->first();

        $this->assertEquals(95, $existencia->cantidad);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testExistenciaCantidadPretransferenciaOrigenRegresaACero()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $existencia = App\ProductoSucursal::where('producto_id', $producto->id)
            ->where('sucursal_id', $transferencia->sucursal_origen_id)->first()->existencia()->first();

        $this->assertEquals(0, $existencia->cantidad_pretransferencia);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testExistenciaCantidadTransferenciaOrigenAumenta()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $existencia = App\ProductoSucursal::where('producto_id', $producto->id)
            ->where('sucursal_id', $transferencia->sucursal_origen_id)->first()->existencia()->first();

        $this->assertEquals(5, $existencia->cantidad_transferencia);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testExistenciaCantidadDestinoPermaneceIntacto()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $existencia = App\ProductoSucursal::where('producto_id', $producto->id)
            ->where('sucursal_id', $transferencia->sucursal_destino_id)->first()->existencia()->first();

        $this->assertEquals(0, $existencia->cantidad);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testTransferirHaceRollbacks()
    {
        $producto = $this->setUpProducto();
        $transferencia = $this->setUpTransferencia();
        $this->setUpBadDetalle();
        $transferencia->transferir();

        $pms = $producto->movimientos($transferencia->sucursalOrigen()->first());

        $this->assertCount(0, $pms);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testCargarEsExitoso()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $this->assertTrue($transferencia->cargar($params));
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testCargarExitosoPoneElEstadoAFinalizado()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];
        $transferencia->cargar($params);

        $estadoFinal = App\EstadoTransferencia::finalizada();

        $this->assertEquals($estadoFinal, $transferencia->estado_transferencia_id);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testCargarCreaUnProductoMovimiento()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $count = App\ProductoMovimiento::count();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $this->assertGreaterThan($count, App\ProductoMovimiento::count());
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testProductoMovimientoEstableceEntraronComoCantidadDelDetalle()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $pm = App\ProductoMovimiento::last();

        $this->assertEquals(5, $pm->entraron);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testProductoMovimientoEstableceCeroSalieron()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $pm = App\ProductoMovimiento::last();

        $this->assertEquals(0, $pm->salieron);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testProductoMovimientoExistenciasAntes()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $pm = App\ProductoMovimiento::last();

        $this->assertEquals(0, $pm->existencias_antes);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testProductoMovimientoExistenciasDespues()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $pm = App\ProductoMovimiento::last();

        $this->assertEquals(5, $pm->existencias_despues);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testExistenciasOrigenTransferenciaRegresaACero()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $existencia = $producto->existencias($producto->sucursales->first());

        $this->assertEquals(0, $existencia->cantidad_transferencia);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testExistenciaDestinoCantidadAumenta()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $existencia = $producto->existencias($producto->sucursales->last());

        $this->assertEquals(5, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testExistenciaDestinoCantidadPretransferenciaDestinoDisminuye()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $existencia = $producto->existencias($producto->sucursales->last());

        $this->assertEquals(0, $existencia->cantidad_pretransferencia_destino);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testDetalleExistenciaOrigenAntes()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $detalle = $transferencia->detalles()->first();

        $this->assertEquals(100, $detalle->existencia_origen_antes);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testDetalleExistenciaOrigenDespues()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $detalle = $transferencia->detalles()->first();

        $this->assertEquals(95, $detalle->existencia_origen_despues);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testDetalleExistenciaDestinoAntes()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $detalle = $transferencia->detalles()->first();

        $this->assertEquals(0, $detalle->existencia_destino_antes);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testDetalleExistenciaDestinoDespues()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $transferencia->cargar($params);

        $detalle = $transferencia->detalles()->first();

        $this->assertEquals(5, $detalle->existencia_destino_despues);
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testCargarHaceRollbacksCuandoUnModeloNoSeGuarda()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpDetalle();
        $transferencia->transferir();

        $sucursalDestino = $producto->sucursales->last();
        $sucursalOrigen = App\Sucursal::find($sucursalDestino->id - 1);

        $existencia = $producto->existencias($sucursalOrigen);
        $existencia->cantidad_transferencia = 0;
        $existencia->save();

        $count = App\ProductoMovimiento::count();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $this->assertFalse($transferencia->cargar($params));
        $this->assertEquals($count, App\ProductoMovimiento::count());
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testCargarNoCargaSiNoEstaEnElEstadoCorrecto()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpBadDetalle();
        $transferencia->transferir();

        $params = ['empleado_id' => App\Empleado::last()->id];

        $this->assertFalse($transferencia->cargar($params));
    }

    /**
     * @covers ::cargar
     * @group feature-transferencias
     * @group cargar
     */
    public function testCargarSinEmpleadoIdEnParametrosRegresaFalse()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $this->setUpBadDetalle();
        $transferencia->transferir();

        $params = [];

        $this->assertFalse($transferencia->cargar($params));
    }

    /**
     * @covers ::escanear
     * @group feature-transferencias
     * @group escanear
     */
    public function testEscanearExitoso()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $this->assertTrue($transferencia->escanear($detalle->id, 1));
    }

    /**
     * @covers ::escanear
     * @group feature-transferencias
     * @group escanear
     */
    public function testEscanearNoExitoso()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $this->assertFalse($transferencia->escanear($detalle->id + 1, 1));
    }

    /**
     * @covers ::resetDetalle
     * @group feature-transferencia
     * @group resetDetalle
     */
    public function testResetDetalleExitoso()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $this->assertTrue($transferencia->resetDetalle($detalle->id));
    }

    /**
     * @covers ::resetDetalle
     * @group feature-transferencia
     * @group resetDetalle
     */
    public function testResetDetalleNoExitoso()
    {
        $producto = $this->setUpProductoForCarga();
        $transferencia = $this->setUpTransferencia();
        $detalle = $this->setUpDetalle();
        $transferencia->transferir();

        $this->assertFalse($transferencia->resetDetalle($detalle->id + 1));
    }

    private function setUpProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursalOrigen = factory(App\Sucursal::class)->create();
        $sucursalDestino = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursalOrigen);
        $producto->addSucursal($sucursalDestino);

        $productoSucursal = $producto->productosSucursales()->where('sucursal_id', $sucursalOrigen->id)->first();
        $productoSucursal->existencia()->create([
            'cantidad' => 95,
            'cantidad_apartado' => 0,
            'cantidad_pretransferencia' => 5,
            'cantidad_pretransferencia_destino' => 0,
            'cantidad_transferencia' => 0,
            'cantidad_garantia_cliente' => 0,
            'cantidad_garantia_zegucom' => 0
        ]);

        $productoSucursal = $producto->productosSucursales()->where('sucursal_id', $sucursalDestino->id)->first();
        $productoSucursal->existencia()->create([
            'cantidad' => 0,
            'cantidad_apartado' => 0,
            'cantidad_pretransferencia' => 0,
            'cantidad_pretransferencia_destino' => 5,
            'cantidad_transferencia' => 0,
            'cantidad_garantia_cliente' => 0,
            'cantidad_garantia_zegucom' => 0
        ]);
        return $producto;
    }

    private function setUpProductoForCarga()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursalOrigen = factory(App\Sucursal::class)->create();
        $sucursalDestino = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursalOrigen);
        $producto->addSucursal($sucursalDestino);

        $productoSucursal = $producto->productosSucursales()->where('sucursal_id', $sucursalOrigen->id)->first();
        $productoSucursal->existencia()->create([
            'cantidad' => 95,
            'cantidad_apartado' => 0,
            'cantidad_pretransferencia' => 0,
            'cantidad_pretransferencia_destino' => 0,
            'cantidad_transferencia' => 5,
            'cantidad_garantia_cliente' => 0,
            'cantidad_garantia_zegucom' => 0
        ]);

        $productoSucursal = $producto->productosSucursales()->where('sucursal_id', $sucursalDestino->id)->first();
        $productoSucursal->existencia()->create([
            'cantidad' => 0,
            'cantidad_apartado' => 0,
            'cantidad_pretransferencia' => 0,
            'cantidad_pretransferencia_destino' => 5,
            'cantidad_transferencia' => 0,
            'cantidad_garantia_cliente' => 0,
            'cantidad_garantia_zegucom' => 0
        ]);
        return $producto;
    }

    private function setUpTransferencia()
    {
        $this->setUpEstados();
        $producto = App\Producto::last();
        $sucursalDestino = $producto->sucursales->last();
        $sucursalOrigen = App\Sucursal::find($sucursalDestino->id - 1);
        $empleado = factory(App\Empleado::class)->create(['sucursal_id' => $sucursalOrigen->id]);

        $transferencia = new App\Transferencia([
            'sucursal_origen_id' => $sucursalOrigen->id,
            'sucursal_destino_id' => $sucursalDestino->id,
            'empleado_origen_id' => $empleado->id
        ]);
        $transferencia->save();
        return $transferencia;
    }

    private function setUpEstados()
    {
        App\EstadoTransferencia::create(['nombre' => 'Abierta']);
        App\EstadoTransferencia::create(['nombre' => 'Cargando Origen']);
        App\EstadoTransferencia::create(['nombre' => 'En transferencia']);
        App\EstadoTransferencia::create(['nombre' => 'Cargando Destino']);
        App\EstadoTransferencia::create(['nombre' => 'Finalizada']);
    }

    private function setUpDetalle($cantidad = 5)
    {
        $producto = App\Producto::last();
        $transferencia = App\Transferencia::last();

        $detalle = [
            'cantidad' => $cantidad,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];
        return $transferencia->agregarDetalle($detalle);
    }

    private function setUpBadDetalle()
    {
        $producto = App\Producto::last();
        $transferencia = App\Transferencia::last();

        $detalle = [
            'cantidad' => 5000,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];
        return $transferencia->agregarDetalle($detalle);
    }
}
