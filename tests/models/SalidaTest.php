<?php

/**
 * @coversDefaultClass \App\Salida
 */
class SalidaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $salida = factory(App\Salida::class)->make();
        $this->assertTrue($salida->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $salida = factory(App\Salida::class, 'full')->create();
        $salida->motivo = 'MC Hammer';
        $this->assertTrue($salida->isValid('update'));
        $this->assertTrue($salida->save());
        $this->assertSame('MC Hammer', $salida->motivo);
    }

    /**
     * @coversNothing
     */
    public function testFechaSalidaEsOpcional()
    {
        $salida = factory(App\Salida::class)->make();
        $this->assertTrue($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaSalidaEsTimestamp()
    {
        $salida = factory(App\Salida::class)->make(['fecha_salida' => 'aaa']);
        $this->assertFalse($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMotivoEsObligatorio()
    {
        $salida = factory(App\Salida::class)->make(['motivo' => null]);
        $this->assertFalse($salida->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMotivoNoPuedeSerLargo()
    {
        $salida = factory(App\Salida::class, 'longmotivo')->make();
        $this->assertFalse($salida->isValid());
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\Empleado::class, $salida->empleado);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleadoAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['empleado_id' => null]);
        $empleado = factory(App\Empleado::class)->create();
        $salida->empleado()->associate($empleado);
        $this->assertSame(1, count($salida->empleado));
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\Sucursal::class, $salida->sucursal);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursalAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['sucursal_id' => null]);
        $sucursal = factory(App\Sucursal::class)->create();
        $salida->sucursal()->associate($sucursal);
        $this->assertSame(1, count($salida->sucursal));
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $salida = factory(App\Salida::class, 'full')->make();
        $this->assertInstanceOf(App\EstadoSalida::class, $salida->estado);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $salida = factory(App\Salida::class, 'full')->make(['estado_salida_id' => null]);
        $es = factory(App\EstadoSalida::class)->create();
        $salida->estado()->associate($es);
        $this->assertSame(1, count($salida->estado));
    }
}
