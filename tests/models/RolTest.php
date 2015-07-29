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
        $rol = factory(App\Rol::class)->make(['clave' => 'AAAAAAA']);
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
}
