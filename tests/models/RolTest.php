<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\Rol
 */
class RolTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $rol = factory(App\Rol::class)->make();
        $this->assertTrue($rol->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $rol = factory(App\Rol::class)->create();
        $rol->nombre = 'MC Hammer';
        $this->assertTrue($rol->isValid('update'));
        $this->assertTrue($rol->save());
        $this->assertSame('MC Hammer', $rol->nombre);
    }

    /**
     * @coversNothing
     */
    public function testClaveEsObligatoria()
    {
        $rol = factory(App\Rol::class)->make(['clave' => null]);
        $this->assertFalse($rol->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio()
    {
        $rol = factory(App\Rol::class)->make(['nombre' => null]);
        $this->assertFalse($rol->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeSerLarga()
    {
        $rol = factory(App\Rol::class)->make(['clave' => 'QWERYTUIOPASDFGHJKLÑZXCVBNMS']);
        $this->assertFalse($rol->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo()
    {
        $rol = factory(App\Rol::class, 'longname')->make();
        $this->assertFalse($rol->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveSeGuardaEnMayusculas()
    {
        $rol = factory(App\Rol::class, 'minclave')->make();
        $claveMinuscula = $rol->clave;
        $rol->save();
        $this->assertSame(strtoupper($claveMinuscula), $rol->clave);
    }

    /**
     * @coversNothing
     * @group feature-permisos
     */
    public function testIndividualEsObligatorio()
    {
        $rol = factory(App\Rol::class)->make(['individual' => null]);
        $this->assertFalse($rol->isValid());
    }

    /**
     * @covers ::empleados
     * @group feature-permisos
     */
    public function testEmpleados()
    {
        $this->expectsEvents(App\Events\EmpleadoCreado::class);

        $empleado = factory(App\Empleado::class)->create();
        $rol = factory(App\Rol::class)->create();

        $rol->empleados()->attach($empleado->id);

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rol->empleados);
        $this->assertInstanceOf(App\Empleado::class, $rol->empleados()->first());
        $this->assertCount(1, $rol->empleados);
    }

    /**
     * @covers ::permisos
     * @group feature-permisos
     */
    public function testPermisos()
    {
        $rol = factory(App\Rol::class)->create();
        $permiso = factory(App\Permiso::class)->create();

        $rol->permisos()->attach($permiso->id);

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rol->permisos);
        $this->assertInstanceOf(App\Permiso::class, $rol->permisos()->first());
        $this->assertCount(1, $rol->permisos);
    }

    /**
     * @covers ::permisos
     * @covers ::agregarPermisos
     * @group feature-permisos
     */
    public function testUnRolPuedeAgregarPermisos()
    {
        $rol = factory(App\Rol::class)->create();
        $permiso = factory(App\Permiso::class)->create();

        $rol->agregarPermisos([$permiso]);
        $this->assertGreaterThan(0, count($rol->permisos));
    }

    /**
     * @covers ::permisos
     * @covers ::quitarPermisos
     * @group feature-permisos
     */
    public function testUnRolPuedeQuitarPermisos()
    {
        $rol = factory(App\Rol::class)->create();
        $permiso = factory(App\Permiso::class)->create();
        $rol->permisos()->attach($permiso->id);

        $rol->quitarPermisos([$permiso]);
        $this->assertEquals(0, count($rol->permisos));
    }

    /**
     * @covers ::permisosRoles
     * @group feature-permisos
     */
    public function testPermisosRoles()
    {
        // Empleados
        $empleado = factory(App\Empleado::class)->create();

        // Roles
        $rolGeneral1 = factory(App\Rol::class)->create();
        $rolGeneral2 = factory(App\Rol::class)->create();
        $rolEmpleado = $empleado->roles->last();

        // Permisos
        $permiso1 = factory(App\Permiso::class)->create();
        $permiso2 = factory(App\Permiso::class)->create();
        $permiso3 = factory(App\Permiso::class)->create();

        // Asignar Permisos a los Roles
        $rolGeneral1->agregarPermisos([$permiso1, $permiso2]);
        $rolGeneral2->agregarPermisos([$permiso1]);
        $rolEmpleado->agregarPermisos([$permiso2, $permiso3]);

        $roles = App\Rol::permisosRoles();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $roles);
        $this->assertInstanceOf(App\Rol::class, $roles->first());
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $roles->first()->permisos);
        $this->assertInstanceOf(App\Permiso::class, $roles->first()->permisos->first());
        $this->assertTrue($roles->pluck('permisos')->collapse()->contains($permiso1));
    }

    /**
     * @covers ::PermisosIndividuales
     * @group feature-permisos
     */
    public function testPermisosIndividuales()
    {
        // Empleados
        $empleado = factory(App\Empleado::class)->create();

        // Roles
        $rolGeneral1 = factory(App\Rol::class)->create();
        $rolGeneral2 = factory(App\Rol::class)->create();
        $rolEmpleado = $empleado->roles->last();

        // Permisos
        $permiso1 = factory(App\Permiso::class)->create();
        $permiso2 = factory(App\Permiso::class)->create();
        $permiso3 = factory(App\Permiso::class)->create();

        // Asignar Permisos a los Roles
        $rolGeneral1->agregarPermisos([$permiso1, $permiso2]);
        $rolGeneral2->agregarPermisos([$permiso1]);
        $rolEmpleado->agregarPermisos([$permiso2, $permiso3]);

        $roles = App\Rol::permisosIndividuales();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $roles);
        $this->assertInstanceOf(App\Rol::class, $roles->first());
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $roles->first()->permisos);
        $this->assertInstanceOf(App\Permiso::class, $roles->first()->permisos->first());
        $this->assertTrue($roles->pluck('permisos')->collapse()->contains($permiso2));
    }
}
