<?php

/**
 * @coversDefaultClass \App\Rol
 */
class RolTest extends TestCase {

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
}
