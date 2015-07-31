<?php

/**
 * @coversDefaultClass \App\SucursalEnvio
 */
class SucursalEnvioTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testSucursalOrigenRequerido() {
        $sucursal_envio = factory(App\SucursalEnvio::class)->make([
            'sucursal_origen_id' => null
        ]);
        $this->assertFalse($sucursal_envio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalDestinoRequerido() {
        $sucursal_envio = factory(App\SucursalEnvio::class)->make([
            'sucursal_destino_id' => null
        ]);
        $this->assertFalse($sucursal_envio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testGeneraCostoRequerido() {
        $sucursal_envio = factory(App\SucursalEnvio::class)->make([
            'genera_costo' => null
        ]);
        $this->assertFalse($sucursal_envio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testGeneraCostoBooleano() {
        $sucursal_envio = factory(App\SucursalEnvio::class)->make([
            'genera_costo' => 5
        ]);
        $this->assertFalse($sucursal_envio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalDiasMaximosDeEnvioRequerido() {
        $sucursal_envio = factory(App\SucursalEnvio::class)->make([
            'dias_max_envio' => null
        ]);
        $this->assertFalse($sucursal_envio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDiasMaximosDeEnvioNoPuedeSerNegativo() {
        $sucursal_envio = factory(App\SucursalEnvio::class)->make([
            'dias_max_envio' => - 1
        ]);
        $this->assertFalse($sucursal_envio->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $model = factory(App\SucursalEnvio::class)->create();
        $model->genera_costo = rand(0, 1);
        $model->dias_max_envio = rand(1, 99);
        $this->assertTrue($model->isValid('update'));
        $this->assertTrue($model->save());
    }


    /**
     * @covers ::sucursalOrigen
     * @group relaciones
     */
    public function testSucursalOrigen() {
        $sucursal = factory(App\Sucursal::class)->create();
        $sucursal_envio = factory(App\SucursalEnvio::class)->create([
            'sucursal_origen_id' => $sucursal->id
        ]);
        $sucursal_resultado = $sucursal_envio->sucursalOrigen;
        $this->assertEquals($sucursal, $sucursal_resultado);
    }

    /**
     * @covers ::sucursalDestino
     * @group relaciones
     */
    public function testSucursalDestino() {
        $sucursal = factory(App\Sucursal::class)->create();
        $sucursal_envio = factory(App\SucursalEnvio::class)->create([
            'sucursal_destino_id' => $sucursal->id
        ]);
        $sucursal_resultado = $sucursal_envio->sucursalDestino;
        $this->assertEquals($sucursal, $sucursal_resultado);
    }
}
