<?php

/**
 * @coversDefaultClass \App\Entrada
 */
class EntradaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $entrada = factory(App\Entrada::class)->make();
        $this->assertTrue($entrada->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $entrada = factory(App\Entrada::class, 'full')->create();
        $entrada->moneda = 'MC Hammer';
        $this->assertTrue($entrada->isValid('update'));
        $this->assertTrue($entrada->save());
        $this->assertSame('MC Hammer', $entrada->moneda);
    }

    /**
     * @coversNothing
     */
    public function testFacturaExternaNumeroEsObligatorio()
    {
        $entrada = factory(App\Entrada::class)->make(['factura_externa_numero' => null]);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFacturaExternaNumeroNoPuedeSerLargo()
    {
        $entrada = factory(App\Entrada::class, 'longfen')->make();
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFacturaFechaNoEsObligatorio()
    {
        $entrada = factory(App\Entrada::class)->make(['factura_fecha' => null]);
        $this->assertTrue($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFacturaFechaEsTimestamp()
    {
        $entrada = factory(App\Entrada::class)->make(['factura_fecha' => 'a']);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMonedaEsObligatorio()
    {
        $entrada = factory(App\Entrada::class)->make(['moneda' => null]);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMonedaNoPuedeSerLarga()
    {
        $entrada = factory(App\Entrada::class, 'longmoneda')->make();
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoDeCambioEsObligatorio()
    {
        $entrada = factory(App\Entrada::class)->make(['tipo_cambio' => null]);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoDeCambioEsDecimal()
    {
        $entrada = factory(App\Entrada::class)->make(['tipo_cambio' => 'a']);
        $this->assertFalse($entrada->isValid());
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstado()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $estado = $entrada->estado;
        $this->assertInstanceOf(App\EstadoEntrada::class, $estado);
    }

    /**
     * @covers ::estado
     * @group relaciones
     */
    public function testEstadoAssociate()
    {
        $entrada = factory(App\Entrada::class, 'noestado')->make(['estado_entrada_id' => null]);
        $estado = factory(App\EstadoEntrada::class)->create();
        $entrada->estado()->associate($estado);
        $entrada->save();
        $this->assertInstanceOf(App\EstadoEntrada::class, $entrada->estado);
        $this->assertSame(1, count($entrada->estado));
    }

    /**
     * @covers ::proveedor
     * @group relaciones
     */
    public function testProveedor()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $proveedor = $entrada->proveedor;
        $this->assertInstanceOf(App\Proveedor::class, $proveedor);
    }

    /**
     * @covers ::proveedor
     * @group relaciones
     */
    public function testProveedorAssociate()
    {
        $entrada = factory(App\Entrada::class, 'noproveedor')->make();
        $proveedor = factory(App\Proveedor::class)->create();
        $entrada->proveedor()->associate($proveedor);
        $entrada->save();
        $this->assertInstanceOf(App\Proveedor::class, $entrada->proveedor);
        $this->assertSame(1, count($entrada->proveedor));
    }

    /**
     * @covers ::razonSocial
     * @group relaciones
     */
    public function testRazonSocial()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $rse = $entrada->razonSocial;
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $rse);
    }

    /**
     * @covers ::razonSocial
     * @group relaciones
     */
    public function testRazonSocialAssociate()
    {
        $entrada = factory(App\Entrada::class, 'norazonsocial')->make();
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create();
        $entrada->razonSocial()->associate($rse);
        $entrada->save();
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $entrada->razonSocial);
        $this->assertSame(1, count($entrada->razonSocial));
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado()
    {
        $entrada = factory(App\Entrada::class, 'full')->make();
        $empleado = $entrada->empleado;
        $this->assertInstanceOf(App\Empleado::class, $empleado);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleadoAssociate()
    {
        $entrada = factory(App\Entrada::class, 'noempleado')->make();
        $empleado = factory(App\Empleado::class)->create();
        $entrada->empleado()->associate($empleado);
        $entrada->save();
        $this->assertInstanceOf(App\Empleado::class, $entrada->empleado);
        $this->assertSame(1, count($entrada->empleado));
    }

    /**
     * @covers ::detalles
     * @group relaciones
     */
    public function testDetalles()
    {
        $entrada = factory(App\Entrada::class, 'full')->create();
        $ed = factory(App\EntradaDetalle::class, 'full')->create(['entrada_id' => $entrada->id]);
        $detalles = $entrada->detalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $detalles);
        $this->assertInstanceOf(App\EntradaDetalle::class, $detalles[0]);
        $this->assertCount(1, $detalles);
    }
}
