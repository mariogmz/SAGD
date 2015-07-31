<?php

/**
 * @coversDefaultClass \App\LogAcceso
 */
class LogAccesoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testEmpleadoRequerido()
    {
        $log = factory(App\LogAcceso::class)->make([
            'empleado_id' => null
        ]);
        $this->assertFalse($log->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExitosoEsRequerido()
    {
        $log = factory(App\LogAcceso::class)->make([
            'exitoso' => null
        ]);
        $this->assertFalse($log->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExitosoEsBooleano()
    {
        $log = factory(App\LogAcceso::class)->make([
            'exitoso' => 'boolean'
        ]);
        $this->assertFalse($log->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTieneTimestamps()
    {
        $log = factory(App\LogAcceso::class)->create();
        $this->assertNotEmpty($log->created_at);
        $this->assertNotEmpty($log->updated_at);
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $model = factory(App\LogAcceso::class)->create();
        $model->exitoso = false;
        $this->assertTrue($model->isValid('update'));
        $this->assertTrue($model->save());
    }

    /**
     * @covers ::empleado
     */
    public function testEmpleado()
    {
        $empleado = factory(App\Empleado::class)->create();
        $log = factory(App\LogAcceso::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $empleado_resultado = $log->empleado;
        $this->assertEquals($empleado->id, $empleado_resultado->id);
    }
}
