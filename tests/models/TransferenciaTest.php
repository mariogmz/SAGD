<?php

/**
 * @coversDefaultClass \App\Transferencia
 */
class TransferenciaTest extends TestCase {

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
}
