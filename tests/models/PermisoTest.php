<?php

/**
 * @coversDefaultClass \App\Permiso
 */
class PermisoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido() {
        $permiso = factory(App\Permiso::class)->make();
        $this->assertTrue($permiso->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $permiso = factory(App\Permiso::class)->create();
        $controlador = "MCHammer".time();
        $permiso->controlador = $controlador;
        $this->assertTrue($permiso->isValid('update'));
        $this->assertTrue($permiso->save());
        $this->assertSame($controlador, $permiso->controlador);
    }

    /**
     * @coversNothing
     */
    public function testControladorEsObligatorio() {
        $permiso = factory(App\Permiso::class)->make(['controlador' => null]);
        $this->assertFalse($permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testControladorNoPuedeTenerMasDe45Caracteres() {
        $permiso = factory(App\Permiso::class, 'longcontrolador')->make();
        $this->assertFalse($permiso->isValid());
    }


    /**
     * @coversNothing
     */
    public function testAccionEsObligatorio() {
        $permiso = factory(App\Permiso::class)->make(['accion' => null]);
        $this->assertFalse($permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testAccionNoPuedeTenerMasDe45Caracteres() {
        $permiso = factory(App\Permiso::class, 'longaccion')->make();
        $this->assertFalse($permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionEsObligatorio() {
        $permiso = factory(App\Permiso::class)->make(['descripcion' => null]);
        $this->assertFalse($permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoPuedeTenerMasDe45Caracteres() {
        $permiso = factory(App\Permiso::class, 'longdesc')->make();
        $this->assertFalse($permiso->isValid());
    }


    /**
     * @coversNothing
     */
    public function testControladorEsUnica() {
        $permiso = factory(App\Permiso::class)->make();
        $permiso_dup = clone $permiso;
        $permiso->save();
        $this->assertFalse($permiso_dup->isValid());
    }

    /**
     * @covers ::roles
     * @group feature-permisos
     */
    public function testRoles()
    {
        $permiso = factory(App\Permiso::class)->create();
        $rol = factory(App\Rol::class)->create();

        $permiso->roles()->attach($rol->id);

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $permiso->roles);
        $this->assertInstanceOf(App\Rol::class, $permiso->roles()->first());
        $this->assertCount(1, $permiso->roles);
    }

    /**
     * @covers ::permisosRoles
     * @group feature-permisos
     */
    public function testPermisosRoles()
    {
        $permisoGeneral = factory(App\Permiso::class)->create();
        $permisoEmpleado = factory(App\Permiso::class)->create();
        $rolGeneral = factory(App\Rol::class)->create();
        $rolEmpleado = factory(App\Rol::class)->create();
        $empleado = factory(App\Empleado::class)->create();

        $rolGeneral->agregarPermisos([$permisoGeneral]);
        $rolEmpleado->agregarPermisos([$permisoEmpleado]);

        $permisos = App\Permiso::permisosRoles();
    }
}

