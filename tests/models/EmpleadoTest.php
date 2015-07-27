<?php

use App\Empleado;

class EmpleadoTest extends TestCase {


    /**
     * @coversNothing
     */
    public function testModeloEmpleadoExiste()
    {
        $empleado = new Empleado();
        $this->assertInstanceOf(Empleado::class, $empleado);
    }

    /**
     * @coversNothing
     */
    public function testModeloEmpleadosAsociadoTablaEmpleados()
    {
        $empleado = new Empleado();
        $this->assertAttributeEquals('empleados', 'table', $empleado);
    }

    /**
     * @coversNothing
     */
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

    /**
     * @coversNothing
     */
    public function testModeloEmpleadosTienePasswordDiferenteDeUsuario()
    {
        $empleado = factory(Empleado::class)->make([
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
        $empleados = factory(Empleado::class, 3)->make([
            'usuario' => 'prueba'
        ]);
        foreach($empleados as $empleado){
            $this->assertFalse($empleado->isValid());
        }
    }
}
