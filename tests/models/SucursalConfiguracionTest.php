<?php

/**
 * @coversDefaultClass \App\SucursalConfiguracion
 */
class SucursalConfiguracionTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testValorNumeroEsDecimal()
    {
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->make([
            'valor_numero' => 'string'
        ]);
        $this->assertFalse($sucursal_configuracion->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorTextoEsTexto()
    {
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->make([
            'valor_texto' => 123456
        ]);
        $this->assertFalse($sucursal_configuracion->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSiValorNumeroEsVacioValorTextoEsRequerido()
    {
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->make([
            'valor_numero' => null,
            'valor_texto'  => 'string'
        ]);
        $this->assertTrue($sucursal_configuracion->isValid());
    }


    /**
     * @coversNothing
     */
    public function testSiValorTextoEsVacioValorNumeroEsRequerido()
    {
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->make([
            'valor_numero' => 123456,
            'valor_texto'  => null
        ]);
        $this->assertTrue($sucursal_configuracion->isValid());
    }

    /**
     * @coversNothing
     */
    public function testAlMenosUnValorEsRequerido()
    {
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->make([
            'valor_numero' => null,
            'valor_texto'  => null
        ]);
        $this->assertFalse($sucursal_configuracion->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorDeConfiguracionEsNumeroOTextoPeroNoLosDos()
    {
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->make([
            'valor_numero' => 123456,
            'valor_texto'  => 'string'
        ]);
        $this->assertFalse($sucursal_configuracion->save());
    }


    /**
     * @coversNothing
     */
    public function testSucursalEsRequerido()
    {
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->make([
            'sucursal_id' => null
        ]);
        $this->assertFalse($sucursal_configuracion->isValid());
    }

    /**
     * @coversNothing
     */
    public function testConfiguracionEsRequerido()
    {
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->make([
            'configuracion_id' => null
        ]);
        $this->assertFalse($sucursal_configuracion->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $model = factory(App\SucursalConfiguracion::class, 'valornumero')->create();
        $model->valor_numero = null;
        $model->valor_texto = 'Thank you Mario! But our Princess is in another castle!';
        $this->assertTrue($model->isValid('update'));
        $this->assertTrue($model->save());
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->create([
            'sucursal_id' => $sucursal->id
        ]);
        $sucursal_resultado = $sucursal_configuracion->sucursal;
        $this->assertEquals($sucursal->id, $sucursal_resultado->id);
    }

    /**
     * @covers ::configuracion
     * @group relaciones
     */
    public function testConfiguracion()
    {
        $configuracion = factory(App\Configuracion::class)->create();
        $sucursal_configuracion = factory(App\SucursalConfiguracion::class)->create([
            'configuracion_id' => $configuracion->id
        ]);
        $configuracion_resultado = $sucursal_configuracion->configuracion;
        $this->assertEquals($configuracion->id, $configuracion_resultado->id);
    }
}
