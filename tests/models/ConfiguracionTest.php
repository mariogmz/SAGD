<?php

/**
 * @coversDefaultClass \App\Configuracion
 */
class ConfiguracionTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido()
    {
        $instance = factory(App\Configuracion::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($instance->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoEsRequerido()
    {
        $instance = factory(App\Configuracion::class)->make([
            'tipo' => ''
        ]);
        $this->assertFalse($instance->isValid());
    }

    /**
     * @coversNothing
     */
    public function testModuloEsRequerido()
    {
        $instance = factory(App\Configuracion::class)->make([
            'modulo' => ''
        ]);
        $this->assertFalse($instance->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsDeMaximo15Caracteres()
    {
        $instance = factory(App\Configuracion::class, 'nombrelargo')->make();
        $this->assertFalse($instance->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoEsDeMaximo10Caracteres()
    {
        $instance = factory(App\Configuracion::class, 'tipolargo')->make();
        $this->assertFalse($instance->isValid());
    }

    /**
     * @coversNothing
     */
    public function testModuloEsDeMaximo10Caracteres()
    {
        $instance = factory(App\Configuracion::class, 'modulolargo')->make();
        $this->assertFalse($instance->isValid());
    }

    /**
     * @coversNothing
     */
    public function testConfiguracionEsValida()
    {
        $instance = factory(App\Configuracion::class)->make();
        $this->assertTrue($instance->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $model = factory(App\Configuracion::class)->create();
        $model->nombre = "CookieCat";
        $this->assertTrue($model->isValid('update'));
        $this->assertTrue($model->save());
    }

    /**
     * @covers ::sucursalesConfiguraciones
     * @group relaciones
     */
    public function testSucursalesConfiguraciones()
    {
        $configuracion = factory(App\Configuracion::class)->create();
        $sucursales_configuraciones = factory(App\SucursalConfiguracion::class, 'valornumero', 5)->create([
            'configuracion_id' => $configuracion->id
        ]);
        $sucursales_configuraciones_resultado = $configuracion->sucursalesConfiguraciones;
        for ($i = 0; $i < 5; $i ++) {
            $this->assertInstanceOf(App\SucursalConfiguracion::class, $sucursales_configuraciones_resultado[$i]);
        }
    }
}
