<?php

/**
 * @coversDefaultClass \App\EmpleadoPermiso
 */
class EmpleadoPermisoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $empleado = factory(App\Empleado::class)->create();
        $empleado_permiso = new App\EmpleadoPermiso(['id_empleado' => $empleado->id]);
        $this->assertTrue($empleado_permiso->isValid());
        $this->assertTrue($empleado_permiso->save());
    }
}
