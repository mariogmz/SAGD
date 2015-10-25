<?php

/**
 * @coversDefaultClass \App\Empleado
 */
class EmpleadoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEmpleadoExiste() {
        $empleado = new App\Empleado();
        $this->assertInstanceOf(App\Empleado::class, $empleado);
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $empleado->nombre = 'Dr. Cod';
        $this->assertTrue($empleado->isValid('update'));
        $this->assertTrue($empleado->save());
    }

    /**
     * @coversNothing
     */
    public function testModeloEmpleadosAsociadoTablaEmpleados() {
        $empleado = new App\Empleado();
        $this->assertAttributeEquals('empleados', 'table', $empleado);
    }

    /**
     * @coversNothing
     */
    public function testModeloEmpleadosTieneValoresNecesarios() {
        $empleado = factory(App\Empleado::class)->make([
            'nombre'   => '',
            'usuario'  => '',
            'activo'   => null,
        ]);
        $this->assertFalse($empleado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCadaEmpleadoTieneUsuarioUnico() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado1 = factory(App\Empleado::class)->create();
        $empleado2 = factory(App\Empleado::class)->make([
            'usuario' => $empleado1->usuario
        ]);
        $this->assertFalse($empleado2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmpleadoEsValido() {
        $empleado = factory(App\Empleado::class)->make();
        $this->assertTrue($empleado->isValid());
    }

    /**
     * @covers ::logsAccesos
     * @group relaciones
     */
    public function testLogsAccesos() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $logs_accesos = factory(App\LogAcceso::class, 5)->create([
            'empleado_id' => $empleado->id
        ]);
        $logs_accesos_resultado = $empleado->logsAccesos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $logs_accesos_resultado);
        $this->assertInstanceOf(App\LogAcceso::class, $logs_accesos_resultado[0]);
        $this->assertCount(5, $logs_accesos_resultado);
    }

    /**
     * @covers ::datoContacto
     * @group relaciones
     */
    public function testDatoContacto() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $dato_contacto = factory(App\DatoContacto::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $dato_contacto_resultado = $empleado->datoContacto;
        $this->assertEquals($dato_contacto->id, $dato_contacto_resultado->id);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $sucursal = factory(App\Sucursal::class)->create();
        $empleado = factory(App\Empleado::class)->create([
            'sucursal_id' => $sucursal->id
        ]);
        $sucursal_resultado = $empleado->sucursal;
        $this->assertInstanceOf(App\Sucursal::class, $sucursal_resultado);
    }

    /**
     * @covers ::serviciosSoportes
     * @group relaciones
     */
    public function testServiciosSoportes() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $servicios_soportes = factory(App\ServicioSoporte::class, 5)->create([
            'empleado_id' => $empleado->id
        ]);
        $servicios_soportes_resultado = $empleado->serviciosSoportes;
        for ($i = 0; $i < 5; $i ++) {
            $this->assertEquals($servicios_soportes[$i]->id, $servicios_soportes_resultado[$i]->id);
        }
    }

    /**
     * @covers ::rmas
     * @group relaciones
     */
    public function testRmas() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        factory(App\Rma::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $empleado->rmas);
        $this->assertInstanceOf(App\Rma::class, $empleado->rmas[0]);
        $this->assertCount(1, $empleado->rmas);
    }

    /**
     * @covers ::salidas
     * @group relaciones
     */
    public function testSalidas() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        factory(App\Salida::class, 'full')->create(['empleado_id' => $empleado->id]);
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $empleado->salidas);
        $this->assertInstanceOf(App\Salida::class, $empleado->salidas[0]);
        $this->assertCount(1, $empleado->salidas);
    }

    /**
     * @covers ::entradas
     * @group relaciones
     */
    public function testEntradas() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $entrada = factory(App\Entrada::class, 'full')->create(['empleado_id' => $empleado->id]);
        $entradas = $empleado->entradas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $entradas);
        $this->assertInstanceOf(App\Entrada::class, $entradas[0]);
        $this->assertCount(1, $entradas);
    }

    /**
     * @covers ::transferenciasOrigen
     * @group relaciones
     */
    public function testTransferenciasOrigen() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $transferencia = factory(App\Transferencia::class, 'full')->create(['empleado_origen_id' => $empleado->id]);
        $transferencias = $empleado->transferenciasOrigen;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $transferencias);
        $this->assertInstanceOf(App\Transferencia::class, $transferencias[0]);
        $this->assertCount(1, $transferencias);
    }

    /**
     * @covers ::transferenciasDestino
     * @group relaciones
     */
    public function testTransferenciasDestino() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $transferencia = factory(App\Transferencia::class, 'full')->create(['empleado_destino_id' => $empleado->id]);
        $transferencias = $empleado->transferenciasDestino;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $transferencias);
        $this->assertInstanceOf(App\Transferencia::class, $transferencias[0]);
        $this->assertCount(1, $transferencias);
    }

    /**
     * @covers ::transferenciasRevision
     * @group relaciones
     */
    public function testTransferenciasRevision() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $transferencia = factory(App\Transferencia::class, 'full')->create(['empleado_revision_id' => $empleado->id]);
        $transferencias = $empleado->transferenciasRevision;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $transferencias);
        $this->assertInstanceOf(App\Transferencia::class, $transferencias[0]);
        $this->assertCount(1, $transferencias);
    }

    /**
     * @covers ::apartados
     * @group relaciones
     */
    public function testApartados() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $apartado = factory(App\Apartado::class, 'full')->create([
            'empleado_apartado_id' => $empleado->id]);
        $apartados = $empleado->apartados;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $apartados);
        $this->assertInstanceOf(App\Apartado::class, $apartados[0]);
        $this->assertCount(1, $apartados);
    }

    /**
     * @covers ::desapartados
     * @group relaciones
     */
    public function testDesapartados() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        factory(App\Apartado::class, 'full')->create([
            'empleado_desapartado_id' => $empleado->id]);
        $apartados = $empleado->desapartados;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $apartados);
        $this->assertInstanceOf(App\Apartado::class, $apartados[0]);
        $this->assertCount(1, $apartados);
    }

    /**
     * @covers ::cortes
     * @group relaciones
     */
    public function testCortes() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        factory(App\Corte::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $cortes = $empleado->cortes;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $cortes);
        $this->assertInstanceOf(App\Corte::class, $cortes[0]);
        $this->assertCount(1, $cortes);
    }

    /**
     * @covers ::ventasMovimientos
     * @group relaciones
     */
    public function testVentasMovimientos() {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $parent = factory(App\Empleado::class)->create();
        factory(App\VentaMovimiento::class)->create([
            'empleado_id' => $parent->id
        ]);
        $children = $parent->ventasMovimientos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\VentaMovimiento', $children[0]);
        $this->assertCount(1, $children);
    }

    /**
     * @covers ::user
     * @group relaciones
     */
    public function testUser()
    {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        factory(App\User::class)->create([
            'morphable_id' => $empleado->id,
            'morphable_type' => get_class($empleado)
        ]);
        $this->assertInstanceOf(App\User::class, $empleado->user);
    }

    /**
     * @covers ::guardar
     * @group guardar-empleado
     */
    public function testGuardarConDatosContacto()
    {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->make();
        $datosContacto = factory(App\DatoContacto::class, 'bare')->make()->toArray();

        $this->assertTrue($empleado->guardar($datosContacto));
        $this->assertNotNull($empleado->datoContacto);
        $this->assertInstanceOf(App\DatoContacto::class, $empleado->datoContacto);
    }

    /**
     * @covers ::guardar
     * @group guardar-empleado
     */
    public function testGuardarDatosEmpleadoNoSeGuarda()
    {
        $empleado = factory(App\Empleado::class)->make();
        $empleado->usuario = null;
        $datosContacto = factory(App\DatoContacto::class, 'bare')->make()->toArray();

        $this->assertFalse($empleado->guardar($datosContacto));
    }

    /**
     * @covers ::guardar
     * @group guardar-empleado
     */
    public function testGuardarDatosDatoContactoNoSeGuarda()
    {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->make();
        $datosContacto = factory(App\DatoContacto::class, 'bare')->make();
        $datosContacto->telefono = 123456789;
        $datosContacto = $datosContacto->toArray();

        $this->assertFalse($empleado->guardar($datosContacto));
    }

    /**
     * @covers ::guardar
     * @group guardar-empleado
     * @group guardar-empleado-rollback
     * @group fix-feature-empleados
     */
    public function testGuardarPuedeHacerRollbacks()
    {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->make(['nombre' => 'MC Hammer']);
        $datosContacto = factory(App\DatoContacto::class, 'bare')->make();
        $datosContacto->telefono = 123456789;
        $datosContacto = $datosContacto->toArray();

        if ($e = App\Empleado::whereNombre('MC Hammer')->first()) {
            $e->forceDelete();
        }

        $this->assertFalse($empleado->guardar($datosContacto));
        $empleado = App\Empleado::whereNombre('MC Hammer')->first();
        $this->assertNull($empleado);
    }

    /**
     * @covers ::actualizar
     * @group actualizar-empleado
     */
    public function testActualizarConDatosDeContacto()
    {
        $empleado = factory(App\Empleado::class)->create();
        $datoContacto = factory(App\DatoContacto::class, 'bare')->make();
        $empleado->datoContacto()->save($datoContacto);

        $params = ['puesto' => 'Debugger', 'datos_contacto' => ['telefono' => '11111']];

        $this->assertTrue($empleado->actualizar($params));
    }

    /**
     * @covers ::actualizar
     * @group actualizar-empleado
     */
    public function testActualizarEmpleadoFalla()
    {
        $empleado = factory(App\Empleado::class)->create();
        $datoContacto = factory(App\DatoContacto::class, 'bare')->make();
        $empleado->datoContacto()->save($datoContacto);

        $params = ['usuario' => null, 'datos_contacto' => ['telefono' => '11111']];

        $this->assertFalse($empleado->actualizar($params));
    }

    /**
     * @covers ::actualizar
     * @group actualizar-empleado
     */
    public function testActualizarDatoContactoFalla()
    {
        $empleado = factory(App\Empleado::class)->create();
        $datoContacto = factory(App\DatoContacto::class, 'bare')->make();
        $empleado->datoContacto()->save($datoContacto);

        $params = ['puesto' => 'Debugger', 'datos_contacto' => ['telefono' => 11111]];

        $this->assertFalse($empleado->actualizar($params));
    }

    /**
     * @covers ::whereEmail
     * @group whereEmail
     */
    public function testWhereEmailEncuentraElModelo()
    {
        $empleado = factory(App\Empleado::class)->create();

        if ($user = App\User::whereEmail('test@test.com')){
            $user->forceDelete();
        }

        $user = new App\User([
            'email' => 'test@test.com',
            'password' => Hash::make('test123'),
            'morphable_id' => $empleado->id,
            'morphable_type' => get_class($empleado)
        ]);
        $user->save();

        $this->assertNotNull($empleado->user);

        $this->assertInstanceOf(App\Empleado::class, App\Empleado::whereEmail('test@test.com'));
        $this->assertNotNull(App\Empleado::whereEmail('test@test.com'));
        $this->assertEquals($empleado->usuario, App\Empleado::whereEmail('test@test.com')->usuario);
    }

    /**
     * @covers ::whereEmail
     * @group whereEmail
     */
    public function testWhereEmailNoEncuentraElModelo()
    {
        $this->assertNull(App\Empleado::whereEmail('a@test.com'));
    }
}
