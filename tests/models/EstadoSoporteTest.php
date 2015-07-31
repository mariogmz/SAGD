<?php

/**
 * @coversDefaultClass \App\EstadoSoporte
 */
class EstadoSoporteTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testClaveEsRequerido()
    {
        $estado_soporte = factory(App\EstadoSoporte::class)->make([
            'clave' => ''
        ]);
        $this->assertFalse($estado_soporte->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $estado_soporte = factory(App\EstadoSoporte::class)->create();
        $estado_soporte->nombre = 'Morgan Freeman';
        $this->assertTrue($estado_soporte->isValid('update'));
        $this->assertTrue($estado_soporte->save());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido()
    {
        $estado_soporte = factory(App\EstadoSoporte::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($estado_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEs6Caracteres()
    {
        $estado_soporte = factory(App\EstadoSoporte::class, 'clavelarga')->make();
        $this->assertFalse($estado_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsMaximo50Caracteres()
    {
        $estado_soporte = factory(App\EstadoSoporte::class, 'nombrelargo')->make();
        $this->assertFalse($estado_soporte->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnico()
    {
        $estado_soporte1 = factory(App\EstadoSoporte::class)->create();
        $estado_soporte2 = factory(App\EstadoSoporte::class)->create([
            'clave' => $estado_soporte1->clave
        ]);
        $this->assertFalse($estado_soporte2->isValid());
    }

    /**
     * @covers ::serviciosSoportes
     */
    public function testServiciosSoportes()
    {
        $estado_soporte = factory(App\EstadoSoporte::class)->create();
        $servicios_soportes = factory(App\ServicioSoporte::class, 5)->create([
            'estado_soporte_id' => $estado_soporte->id
        ]);
        $servicios_soportes_resultado = $estado_soporte->serviciosSoportes;
        for ($i = 0; $i < 5; $i ++)
        {
            $this->assertEquals($servicios_soportes[$i]->id, $servicios_soportes_resultado[$i]->id);
        }
    }
}
