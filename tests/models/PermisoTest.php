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
        $permiso->nombre = 'MC Hammer';
        $this->assertTrue($permiso->isValid('update'));
        $this->assertTrue($permiso->save());
        $this->assertSame('MC Hammer', $permiso->nombre);
    }

    /**
     * @coversNothing
     */
    public function testClaveEsObligatoria() {
        $permiso = factory(App\Permiso::class)->make(['clave' => null]);
        $this->assertFalse($permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeTenerMasDe10Caracteres() {
        $permiso = factory(App\Permiso::class)->make(['clave' => 'aaaaaaaaaaaa']);
        $this->assertFalse($permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveSeGuardaEnMayusculas() {
        $permiso = factory(App\Permiso::class)->make();
        $clave = strtolower($permiso->clave);
        $permiso->clave = $clave;
        $this->assertTrue($permiso->isValid());
        $permiso->save();
        $this->assertSame(strtoupper($clave), $permiso->clave);
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnica() {
        $permiso = factory(App\Permiso::class)->make();
        $permiso_dup = clone $permiso;
        $permiso->save();
        $this->assertFalse($permiso_dup->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio() {
        $permiso = factory(App\Permiso::class)->make(['nombre' => null]);
        $this->assertFalse($permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo() {
        $permiso = factory(App\Permiso::class, 'longnombre')->make();
        $this->assertFalse($permiso->isValid());
    }
}

