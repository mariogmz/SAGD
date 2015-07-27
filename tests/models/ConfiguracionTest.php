<?php

use App\Configuracion;

class ConfiguracionTest extends TestCase {

    public function testNombreEsRequerido()
    {
        $instance = factory(Configuracion::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($instance->isValid());
    }

    public function testTipoEsRequerido()
    {
        $instance = factory(Configuracion::class)->make([
            'tipo' => ''
        ]);
        $this->assertFalse($instance->isValid());
    }

    public function testModuloEsRequerido()
    {
        $instance = factory(Configuracion::class)->make([
            'modulo' => ''
        ]);
        $this->assertFalse($instance->isValid());
    }

    public function testNombreEsDeMaximo15Caracteres()
    {
        $instance = factory(Configuracion::class, 'nombrelargo')->make();
        $this->assertFalse($instance->isValid());
    }

    public function testTipoEsDeMaximo10Caracteres()
    {
        $instance = factory(Configuracion::class, 'tipolargo')->make();
        $this->assertFalse($instance->isValid());
    }

    public function testModuloEsDeMaximo10Caracteres()
    {
        $instance = factory(Configuracion::class, 'modulolargo')->make();
        $this->assertFalse($instance->isValid());
    }

    public function testConfiguracionEsValida()
    {
        $instance = factory(Configuracion::class)->make();
        $this->assertTrue($instance->isValid());
    }
}
