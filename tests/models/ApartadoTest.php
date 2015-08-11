<?php

/**
 * @coversDefaultClass \App\Apartado
 */
class ApartadoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $apartado = factory(App\Apartado::class)->make();
        $this->assertTrue($apartado->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $apartado = factory(App\Apartado::class, 'full')->create();
        $apartado->concepto = 'MC Hammer';
        $this->assertTrue($apartado->isValid('update'));
        $this->assertTrue($apartado->save());
        $this->assertSame('MC Hammer', $apartado->concepto);
    }

    /**
     * @coversNothing
     */
    public function testConceptoEsObligatorio()
    {
        $apartado = factory(App\Apartado::class)->make(['concepto' => null]);
        $this->assertFalse($apartado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testConceptoNoPuedeSerLargo()
    {
        $apartado = factory(App\Apartado::class, 'longconcepto')->make();
        $this->assertFalse($apartado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaApartadoEsOpcional()
    {
        $apartado = factory(App\Apartado::class)->make(['fecha_apartado' => null]);
        $this->assertTrue($apartado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaApartadoEsTimestamp()
    {
        $apartado = factory(App\Apartado::class)->make(['fecha_apartado' => 'a']);
        $this->assertFalse($apartado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaDesapartadoEsOpcional()
    {
        $apartado = factory(App\Apartado::class)->make(['fecha_desapartado' => null]);
        $this->assertTrue($apartado->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaDesapartadoEsTimestamp()
    {
        $apartado = factory(App\Apartado::class)->make(['fecha_desapartado' => 'a']);
        $this->assertFalse($apartado->isValid());
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $apartado = factory(App\Apartado::class, 'full')->make();
        $estado = $apartado->estado;
        $this->assertInstanceOf(App\EstadoApartado::class, $estado);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $apartado = factory(App\Apartado::class, 'full')->make(['estado_apartado_id' => null]);
        $estado = factory(App\EstadoApartado::class)->create();
        $apartado->estado()->associate($estado);
        $this->assertInstanceOf(App\EstadoApartado::class, $apartado->estado);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $apartado = factory(App\Apartado::class, 'full')->make();
        $sucursal = $apartado->sucursal;
        $this->assertInstanceOf(App\Sucursal::class, $sucursal);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursalAssociate()
    {
        $apartado = factory(App\Apartado::class, 'full')->make(['sucursal_id' => null]);
        $sucursal = factory(App\Sucursal::class)->create();
        $apartado->sucursal()->associate($sucursal);
        $this->assertInstanceOf(App\Sucursal::class, $apartado->sucursal);
    }

    /**
     * @covers ::empleadoApartado
     * @group relaciones
     */
    public function testEmpleadoApartado()
    {
        $apartado = factory(App\Apartado::class, 'full')->make();
        $empleadoA = $apartado->empleadoApartado;
        $this->assertInstanceOf(App\Empleado::class, $empleadoA);
    }

    /**
     * @covers ::empleadoApartado
     * @group relaciones
     */
    public function testEmpleadoApartadoAssociate()
    {
        $apartado = factory(App\Apartado::class, 'full')->make(['empleado_apartado_id' => null]);
        $empleado = factory(App\Empleado::class)->create();
        $apartado->empleadoApartado()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $apartado->empleadoApartado);
    }

    /**
     * @covers ::empleadoDesapartado
     * @group relaciones
     */
    public function testEmpleadoDesapartado()
    {
        $apartado = factory(App\Apartado::class, 'full')->make();
        $empleadoD = $apartado->empleadoDesapartado;
        $this->assertInstanceOf(App\Empleado::class, $empleadoD);
    }

    /**
     * @covers ::empleadoDesapartado
     * @group relaciones
     */
    public function testEmpleadoDesapartadoAssociate()
    {
        $apartado = factory(App\Apartado::class, 'full')->make(['empleado_desapartado_id' => null]);
        $empleado = factory(App\Empleado::class)->create();
        $apartado->empleadoDesapartado()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $apartado->empleadoDesapartado);
    }

    /**
     * @covers ::detalles
     * @group relaciones
     */
    public function testDetalles()
    {
        $apartado = factory(App\Apartado::class, 'full')->create();
        $ad = factory(App\ApartadoDetalle::class, 'full')->create(['apartado_id' => $apartado->id]);
        $ads = $apartado->detalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $ads);
        $this->assertInstanceOf(App\ApartadoDetalle::class, $ads[0]);
        $this->assertCount(1, $ads);
    }
}
