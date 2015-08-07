<?php

/**
 * @coversDefaultClass \App\NivelPermiso
 */
class NivelPermisoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido() {
        $nivel_permiso = factory(App\NivelPermiso::class)->make();
        $this->assertTrue($nivel_permiso->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $nivel_permiso = factory(App\NivelPermiso::class)->create();
        $nivel_permiso->nombre = 'MC Hammer';
        $this->assertTrue($nivel_permiso->isValid('update'));
        $this->assertTrue($nivel_permiso->save());
        $this->assertSame('MC Hammer', $nivel_permiso->nombre);
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio() {
        $nivel_permiso = factory(App\NivelPermiso::class)->make(['nombre' => null]);
        $this->assertFalse($nivel_permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeSerLargo() {
        $nivel_permiso = factory(App\NivelPermiso::class, 'longnombre')->make();
        $this->assertFalse($nivel_permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNivelEsObligatorio() {
        $nivel_permiso = factory(App\NivelPermiso::class)->make(['nivel' => null]);
        $this->assertFalse($nivel_permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNivelEsEntero() {
        $nivel_permiso = factory(App\NivelPermiso::class)->make(['nivel' => 'null']);
        $this->assertFalse($nivel_permiso->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNivelEsPositivo() {
        $nivel_permiso = factory(App\NivelPermiso::class)->make(['nivel' => -1]);
        $this->assertFalse($nivel_permiso->isValid());
    }
}

