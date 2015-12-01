<?php

use App\Salida;
use App\SalidaDetalle;
use App\ProductoMovimiento;
use App\Existencia;
use Carbon\Carbon;

use Illuminate\Foundation\Testing\DatabaseTransactions;


/**
 * @coversDefaultClass \App\Salida
 */
class SalidaTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $salida = factory(App\Salida::class)->make();
        $this->assertTrue($salida->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $salida = factory(App\Salida::class, 'full')->create();
        $salida->motivo = 'MC Hammer';
        $this->assertTrue($salida->isValid('update'));
        $this->assertTrue($salida->save());
        $this->assertSame('MC Hammer', $salida->motivo);
    }

    /**
     * @coversNothing
     */
    public function testFechaSalidaEsOpcional()
    {
        $salida = factory(App\Salida::class)->make();
        $this->assertTrue($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaSalidaEsTimestamp()
    {
        $salida = factory(App\Salida::class)->make(['fecha_salida' => 'aaa']);
        $this->assertFalse($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMotivoEsObligatorio()
    {
        $salida = factory(App\Salida::class)->make(['motivo' => null]);
        $this->assertFalse($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMotivoNoPuedeSerLargo()
    {
        $salida = factory(App\Salida::class, 'longmotivo')->make();
        $this->assertFalse($salida->isValid());
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\Empleado::class, $salida->empleado);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleadoAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['empleado_id' => null]);
        $empleado = factory(App\Empleado::class)->create();
        $salida->empleado()->associate($empleado);
        $this->assertSame(1, count($salida->empleado));
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\Sucursal::class, $salida->sucursal);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursalAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['sucursal_id' => null]);
        $sucursal = factory(App\Sucursal::class)->create();
        $salida->sucursal()->associate($sucursal);
        $this->assertSame(1, count($salida->sucursal));
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\EstadoSalida::class, $salida->estado);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['estado_salida_id' => null]);
        $es = factory(App\EstadoSalida::class)->create();
        $salida->estado()->associate($es);
        $this->assertSame(1, count($salida->estado));
    }

    /**
     * @covers ::detalles
     * @group relaciones
     */
    public function testDetalles()
    {
        $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();

        $detalles = $salida->detalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $detalles);
        $this->assertInstanceOf(App\SalidaDetalle::class, $detalles->first());
        $this->assertCount(1, $detalles);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-salidas
     */
    public function testCrearDetalleConParametrosDeDetalleEsExitoso()
    {
        $producto = $this->setUpProducto();

        $salida = $this->setUpSalida();

        $detalles = [
            'cantidad' => 5,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];

        $this->assertInstanceOf(App\SalidaDetalle::class, $salida->crearDetalle($detalles));
    }

    /**
     * @covers ::crearDetalle
     * @group feature-salidas
     */
    public function testCrearDetalleConParametrosIncorrectosNoEsExitoso()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();

        $detalles = [
            'cantidad' => 5,
            'upc' => $producto->upc
        ];

        $this->assertFalse($salida->crearDetalle($detalles));
    }

    /**
     * @covers ::quitarDetalle
     * @group feature-salidas
     */
    public function testQuitarDetalleConDetalleCorrectoEsExitoso()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();

        $detalle_id = SalidaDetalle::last()->id;

        $this->assertTrue($salida->quitarDetalle($detalle_id));
    }

    /**
     * @covers ::quitarDetalle
     * @group feature-salidas
     */
    public function testQuitarDetalleConDetalleIncorrectoNoEsExitoso()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();

        $detalle_id = SalidaDetalle::last()->id + 1;

        $this->assertFalse($salida->quitarDetalle($detalle_id));
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarExitoso()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $this->assertTrue($salida->cargar());
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarCreaProductosMovimientos()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $movimientos = ProductoMovimiento::count();
        $salida->cargar();

        $this->assertGreaterThanOrEqual($movimientos, ProductoMovimiento::count());
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarActualizaLasExistenciasDelProducto()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $salida->cargar();

        $existencia = $producto->existencias(App\Sucursal::last());
        $this->assertEquals(95, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarMultiplesVecesActualizaLasExistenciasDelProducto()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        for ($i=0; $i < 10; $i++) {
            $this->setUpDetalle();
        }

        $salida->cargar();

        $existencia = $producto->existencias(App\Sucursal::last());
        $this->assertEquals(50, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarEstableceBienLasExistenciasAnteriores()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $salida->cargar();

        $pm = $producto->movimientos(App\Sucursal::last())->last();
        $this->assertEquals(100, $pm->existencias_antes);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarEstableceBienLasExistenciasPosteriores()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $salida->cargar();

        $pm = $producto->movimientos(App\Sucursal::last())->last();
        $this->assertEquals(95, $pm->existencias_despues);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testTodosLosDetallesTienenUnProductoMovimientoDespuesDeLaCarga()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();

        $salida->cargar();

        $detalle = $salida->detalles->first();

        $this->assertInstanceOf(App\ProductoMovimiento::class, $detalle->productoMovimiento);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarCuandoActualizarExistenciasFallaLasExistenciasPermanecenIntactas()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();

        $this->mock = Mockery::mock('App\Listeners\ActualizarExistencias');
        $this->mock->shouldReceive([
            'handle' => ['success' => false]
        ]);
        $this->app->instance('App\Listeners\ActualizarExistencias', $this->mock);

        $salida->cargar();

        $existencia = $producto->existencias(App\Sucursal::last());
        $this->assertEquals(100, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     * @group feature-salidas-rollbacks
     */
    public function testCargarRollbackVerificarExistencias()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        for ($i=0; $i < 5; $i++) {
            $this->setUpDetalle();
        }

        $detalle = [
            'cantidad' => 5000,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];
        $salida->crearDetalle($detalle);

        $salida->cargar();

        $existencia = $producto->existencias(App\Sucursal::last());
        $this->assertEquals(100, $existencia->cantidad);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarActualizaElEstadoDeLaSalida()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();

        $estado = $salida->estado_salida_id;

        $salida->cargar();

        $salida = $salida->fresh();

        $this->assertFalse( $estado === $salida->estado_salida_id );
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testSalidaSoloPuedeSerCargadaUnaVez()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();

        $this->assertTrue($salida->cargar());
        $this->assertFalse($salida->cargar());
    }

    /**
     * @covers ::crearDetalle
     * @group feature-salidas
     */
    public function testCargarDosVecesUnDetalleConMismoUpcLoAgrupaEnUnSoloDetalle()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();
        $this->setUpDetalle();

        $this->assertCount(1, $salida->detalles);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-salidas
     */
    public function testCargarMismoDetalleActualizaCorrectamenteLaCantidad()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        for ($i=0; $i < 5; $i++) {
            $this->setUpDetalle();
        }

        $this->assertEquals(25, $salida->detalles->first()->cantidad);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-salidas
     */
    public function testCargarMismoDetalleVariasVecesActualizaCorrectamenteExistencias()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        for ($i=0; $i < 5; $i++) {
            $this->setUpDetalle();
        }

        $salida->cargar();

        $existencia = $producto->existencias(App\Sucursal::last());
        $this->assertEquals(75, $existencia->cantidad);
    }

    /**
     * @covers ::crearDetalle
     * @group feature-salidas
     */
    public function testCargarMismoDetalleVariasVecesSoloCreaUnProductoMovimiento()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        for ($i=0; $i < 5; $i++) {
            $this->setUpDetalle();
        }

        $salida->cargar();

        $movimientos = $producto->movimientos->count();
        $this->assertEquals(1, $movimientos);
    }

    /**
     * @covers ::sobrepasaExistencias
     * @group feature-salidas
     * @group sobrepasa-existencias
     */
    public function testSobrepasaExistenciasConCantidadValida()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle();

        $this->assertFalse($salida->sobrepasaExistencias());
    }

    /**
     * @covers ::sobrepasaExistencias
     * @group feature-salidas
     * @group sobrepasa-existencias
     */
    public function testSobrepasaExistenciasConCantidadInvalida()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $this->setUpDetalle(1000);

        $this->assertTrue($salida->sobrepasaExistencias());
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
        $this->setUpEstados();
        $producto = App\Producto::last();
        $sucursal = App\Sucursal::last();


        $salida = new Salida([
            'motivo' => 'Test',
            'empleado_id' => factory(App\Empleado::class)->create(['sucursal_id' => $sucursal->id])->id,
            'estado_salida_id' => App\EstadoSalida::creando()->id,
            'sucursal_id' => $sucursal->id
        ]);
        $salida->save();
        return $salida;
    }

    private function setUpDetalle($cantidad = 5)
    {
        $producto = App\Producto::last();
        $salida = Salida::last();

        $detalle = [
            'cantidad' => $cantidad,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];

        return $salida->crearDetalle($detalle);
    }

    private function setUpEstados()
    {
        $estadoSalidaCreando = new App\EstadoSalida(['nombre' => 'Creando']);
        $estadoSalidaCargando = new App\EstadoSalida(['nombre' => 'Cargando']);
        $estadoSalidaCargado = new App\EstadoSalida(['nombre' => 'Cargado']);

        $estadoSalidaCreando->save();
        $estadoSalidaCargando->save();
        $estadoSalidaCargado->save();
    }
}
