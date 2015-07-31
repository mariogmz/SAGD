<?php

/**
 * @coversDefaultClass \App\ServicioSoporte
 */
class ServicioSoporteTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDescripcionEquipoEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'descripcion_equipo' => ''
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFallaEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'falla' => ''
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSolucionNoEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'solucion' => ''
        ]);
        $this->assertTrue($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'costo' => null
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaRecepcionEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'fecha_recepcion' => null
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaEntregaNoEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'fecha_entrega' => null
        ]);
        $this->assertTrue($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEstadoSoporteEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'estado_soporte_id' => null
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmpleadoEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'empleado_id' => null
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClienteEsRequerido()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'cliente_id' => null
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionEquipoNoMasDe100Caracteres()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class, 'descripcionlarga')->make();
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFallaNoMasDe100Caracteres()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class, 'fallalarga')->make();
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSolucionNoMasDe100Caracteres()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class, 'solucionlarga')->make();
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoEsDecimal()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'costo' => 'hello'
        ]);
        $this->assertFalse($servicio_soporte->isValid());
        $servicio_soporte->costo = 10.50;
        $this->assertTrue($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaRecepcionEsFecha()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'fecha_recepcion' => 'NotADate'
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaEntregaEsFecha()
    {
        $servicio_soporte = factory(App\ServicioSoporte::class)->make([
            'fecha_entrega' => 'NotADate'
        ]);
        $this->assertFalse($servicio_soporte->isValid());
    }

    /**
     * @covers ::estadoSoporte
     */
    public function testEstadoSoporte()
    {
        $estado_soporte = factory(App\EstadoSoporte::class)->create();
        $servicio_soporte = factory(App\ServicioSoporte::class)->create([
            'estado_soporte_id' => $estado_soporte->id
        ]);
        $this->assertEquals($estado_soporte, $servicio_soporte->estadoSoporte);
    }

    /**
     * @covers ::empleado
     */
    public function testEmpleado()
    {
        $empleado = factory(App\Empleado::class)->create();
        $servicio_soporte = factory(App\ServicioSoporte::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $this->assertEquals($empleado->id, $servicio_soporte->empleado->id);
    }

    /**
     * @covers ::cliente
     */
    public function testCliente()
    {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $servicio_soporte = factory(App\ServicioSoporte::class)->create([
            'cliente_id' => $cliente->id
        ]);
        $this->assertInstanceOf(get_class($cliente), $servicio_soporte->cliente);
    }

    /**
     * @covers ::soportesProductos
     */
    public function testSoportesProductos(){
        $servicio_soporte = factory(App\ServicioSoporte::class)->create();
        factory(App\SoporteProducto::class, 5)->create([
            'servicio_soporte_id' => $servicio_soporte->id
        ]);
        foreach($servicio_soporte->soportesProductos as $sp){
            $this->assertInstanceOf('App\SoporteProducto', $sp);
        }
    }

}
