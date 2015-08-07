<?php

/**
 * @coversDefaultClass \App\MetodoPago
 */
class MetodoPagoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testClaveEsRequerida() {
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'clave' => ''
        ]);
        $this->assertFalse($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnica() {
        $metodo_pago1 = factory(App\MetodoPago::class)->create();
        $metodo_pago2 = factory(App\MetodoPago::class)->make([
            'clave' => $metodo_pago1->clave
        ]);
        $this->assertFalse($metodo_pago2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoMayorA10Caracteres() {
        $metodo_pago = factory(App\MetodoPago::class, 'clavelarga')->make();
        $this->assertFalse($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoEsRequerido() {
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'nombre' => ''
        ]);
        $this->assertTrue($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoMayorA45Caracteres() {
        $metodo_pago = factory(App\MetodoPago::class, 'nombrelargo')->make();
        $this->assertFalse($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testComisionEsRequerido() {
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'comision' => null
        ]);
        $this->assertFalse($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testComisionEsDecimal() {
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'comision' => 'Yehaawww'
        ]);
        $this->assertFalse($metodo_pago->isValid());
        $metodo_pago->comision = 0.125;
        $this->assertTrue($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMontoMinimoEsRequerido() {
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'monto_minimo' => null
        ]);
        $this->assertFalse($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMontoMinimoEsDecimal() {
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'monto_minimo' => 'yuyin'
        ]);

        $this->assertFalse($metodo_pago->isValid());
        $metodo_pago->monto_minimo = 100.50;
        $this->assertTrue($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testInformacionAdicionalNoEsRequerido() {
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'informacion_adicional' => null
        ]);
        $this->assertTrue($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testInformacionAdicionalMaximo100Caracteres() {
        $metodo_pago = factory(App\MetodoPago::class, 'descripcionlarga')->make();
        $this->assertFalse($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEstatusActivoEsRequerido() {
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'estatus_activo_id' => null
        ]);
        $this->assertFalse($metodo_pago->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {

        $metodo_pago = factory(App\MetodoPago::class)->create();
        $metodo_pago->nombre = 'Gollum';
        $this->assertTrue($metodo_pago->isValid('update'));
        $this->assertTrue($metodo_pago->save());
        $this->assertSame('Gollum', $metodo_pago->nombre);
    }

    /**
     * @covers ::estatusActivo
     * @group relaciones
     */
    public function testEstatusActivo() {
        $estatus_activo = factory(App\EstatusActivo::class)->create();
        $metodo_pago = factory(App\MetodoPago::class)->make([
            'estatus_activo_id' => $estatus_activo->id
        ]);
        $estatus_activo_resultado = $metodo_pago->estatusActivo;
        $this->assertEquals($estatus_activo, $estatus_activo_resultado);
    }

    /**
     * @covers ::metodosPagosRangos
     * @group relaciones
     */
    public function testMetodosPagosRangos() {
        $parent = factory(App\MetodoPago::class)->create();
        factory(App\MetodoPagoRango::class, 'truncate')->create([
            'metodo_pago_id' => $parent->id
        ]);
        $children = $parent->metodosPagosRangos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\MetodoPagoRango', $children[0]);
        $this->assertCount(1, $children);
    }


    /**
     * @covers ::ventasDetalles
     * @group relaciones
     */
    public function testVentasDetalles() {
        $parent = factory(App\MetodoPago::class)->create();
        factory(App\VentaDetalle::class, 'producto')->create([
            'metodo_pago_id' => $parent->id
        ]);
        $children = $parent->ventasDetalles;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\VentaDetalle', $children[0]);
        $this->assertCount(1, $children);
    }

}
