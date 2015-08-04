<?php

/**
 * @coversDefaultClass \App\Caja
 */
class CajaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido() {
        $caja = factory(App\Caja::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($caja->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsMaximo45Caracteres() {
        $caja = factory(App\Caja::class, 'nombrelargo')->make();
        $this->assertFalse($caja->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMacAddressEsRequerida() {
        $caja = factory(App\Caja::class)->make([
            'mac_addr' => ''
        ]);
        $this->assertFalse($caja->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMacAddressEsDe17Caracteres() {
        $caja = factory(App\Caja::class, 'maclarga')->make();
        $this->assertFalse($caja->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTokenEsRequerido() {
        $caja = factory(App\Caja::class)->make([
            'token' => ''
        ]);
        $this->assertFalse($caja->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTokenEsDe6Caracteres() {
        $caja = factory(App\Caja::class, 'tokenlargo')->make();
        $this->assertFalse($caja->isValid());
    }

    /**
     * @coversNothing
     */
    public function testIteracionEsUnNumeroEntero() {
        $caja = factory(App\Caja::class)->make([
            'iteracion' => 'DiePotato'
        ]);
        $this->assertFalse($caja->isValid());
        $caja->iteracion = 1;
        $this->assertTrue($caja->isValid());

    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal() {
        $sucursal = factory(App\Sucursal::class)->create();
        $caja = factory(App\Caja::class)->create([
            'sucursal_id' => $sucursal->id
        ]);
        $sucursal_resultado = $caja->sucursal;
        $this->assertEquals($sucursal, $sucursal_resultado);
    }

    /**
     * @covers ::cortes
     * @group relaciones
     */
    public function testCortes() {
        $caja = factory(App\Caja::class)->create();
        factory(App\Corte::class)->create([
            'caja_id' => $caja->id
        ]);
        $cortes = $caja->cortes;
        $this->assertCount(1, $cortes);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $cortes);
        $this->assertInstanceOf('App\Corte', $cortes[0]);
        $this->assertSame($caja->id, $cortes[0]->caja_id);
    }

    /**
     * @covers ::gastosExtras
     * @group relaciones
     */
    public function testGastosExtras(){
        $caja = factory(App\Caja::class)->create();
        factory(App\GastoExtra::class)->create([
            'caja_id' => $caja->id
        ]);
        $gastos_extras = $caja->gastosExtras;
        $this->assertCount(1, $gastos_extras);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $gastos_extras);
        $this->assertInstanceOf('App\GastoExtra', $gastos_extras[0]);
        $this->assertSame($caja->id, $gastos_extras[0]->caja_id);
    }

}
