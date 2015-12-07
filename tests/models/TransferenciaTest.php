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

    private function setUpProducto()
    {
        factory(App\Sucursal::class)->create();
        factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();

        $productoSucursal = $producto->productosSucursales()->last();
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

    private function setUpTransferencia()
    {
        $this->setUpEstados();
        $producto = App\Producto::last();
        $sucursalOrigen = App\Sucursal::last();
        $sucursalDestino = App\Sucursal::find($sucursalOrigen->id - 1);
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
}
