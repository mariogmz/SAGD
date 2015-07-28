<?php

/**
 * @coversDefaultClass \App\Empleado
 */
class EmpleadoTest extends TestCase {


    /**
     * @coversNothing
     */
    public function testModeloEmpleadoExiste()
    {
        $empleado = new App\Empleado();
        $this->assertInstanceOf(App\Empleado::class, $empleado);
    }

    /**
     * @coversNothing
     */
    public function testModeloEmpleadosAsociadoTablaEmpleados()
    {
        $empleado = new App\Empleado();
        $this->assertAttributeEquals('empleados', 'table', $empleado);
    }

    /**
     * @coversNothing
     */
    public function testModeloEmpleadosTieneValoresNecesarios()
    {
        $empleado = factory(App\Empleado::class)->make([
            'nombre'   => '',
            'usuario'  => '',
            'password' => '',
            'activo'   => null,
        ]);
        $this->assertFalse($empleado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testModeloEmpleadosTienePasswordDiferenteDeUsuario()
    {
        $empleado = factory(App\Empleado::class)->make([
            'usuario'  => 'prueba',
            'password' => 'prueba'
        ]);
        $this->assertFalse($empleado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCadaEmpleadoTieneUsuarioUnico()
    {
        $empleado1 = factory(App\Empleado::class)->create();
        $empleado2 = factory(App\Empleado::class)->make([
            'usuario' => $empleado1->usuario
        ]);
        $this->assertFalse($empleado2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmpleadoEsValido()
    {
        $empleado = factory(App\Empleado::class)->make();
        $this->assertTrue($empleado->isValid());
    }

    /**
     * @covers ::logsAccesos
     */
    public function testLogsAccesos()
    {
        $this->markTestIncomplete('Not implemented yet.');

        $empleado = factory(App\Empleado::class)->create();
        $logs_accesos = factory(App\LogAcceso::class, 5)->create([
            'empleado_id' => $empleado->id
        ]);
        $logs_accesos_resultado = $empleado->logsAccesos;
        for ($i = 0; $i < 5; $i ++)
        {
            $this->assertEquals($logs_accesos[$i], $logs_accesos_resultado[$i]);
        }
    }

    /**
     * @covers ::datoContacto
     */
    public function testDatoContacto()
    {
        $empleado = factory(App\Empleado::class)->create();
        $dato_contacto = factory(App\DatoContacto::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $dato_contacto_resultado = $empleado->datoContacto;
        $this->assertEquals($dato_contacto->id, $dato_contacto_resultado->id);
    }

    /**
     * @covers ::sucursal
     */
    public function testSucursal()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $empleado = factory(App\Empleado::class)->create([
            'sucursal_id' => $sucursal->id
        ]);
        $sucursal_resultado = $empleado->sucursal;
        $this->assertEquals($sucursal, $sucursal_resultado);
    }
}
