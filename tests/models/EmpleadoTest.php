<?php

use App\Empleado;

class EmpleadoTest extends TestCase {


    public function testModeloEmpleadoExiste()
    {
        $empleado = new Empleado();
        $this->assertInstanceOf(Empleado::class, $empleado);
    }

    public function testModeloEmpleadosAsociadoTablaEmpleados()
    {
        $empleado = new Empleado();
        $this->assertAttributeEquals('empleados', 'table', $empleado);
    }

    public function testModeloEmpleadosTieneValoresNecesarios()
    {
        $empleado = factory(Empleado::class)->make([
            'nombre'   => '',
            'usuario'  => '',
            'password' => '',
            'activo'   => null,
        ]);
        $this->assertFalse($empleado->isValid());
    }

    public function testModeloEmpleadosTienePasswordDiferenteDeUsuario()
    {
        $empleado = factory(Empleado::class)->make([
            'usuario'  => 'prueba',
            'password' => 'prueba'
        ]);
        $this->assertFalse($empleado->isValid());
    }

    public function testCadaEmpleadoTieneUsuarioUnico()
    {
        $empleados = factory(Empleado::class, 3)->make([
            'usuario' => 'prueba'
        ]);
        foreach($empleados as $empleado){
            $this->assertFalse($empleado->isValid());
        }
    }
}
