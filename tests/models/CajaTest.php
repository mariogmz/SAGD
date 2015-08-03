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
     */
    public function testSucursal() {
        $sucursal = factory(App\Sucursal::class)->create();
        $caja = factory(App\Caja::class)->create([
            'sucursal_id' => $sucursal->id
        ]);
        $sucursal_resultado = $caja->sucursal;
        $this->assertEquals($sucursal, $sucursal_resultado);
    }

}
