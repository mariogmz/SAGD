<?php

/**
 * @coversDefaultClass \App\EstatusVenta
 */
class EstatusVentaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testNombreRequerido(){
        $estatus_venta = factory(App\EstatusVenta::class)->make([
            'nombre' => null
        ]);
        $this->assertFalse($estatus_venta->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsMaximo60Caracteres(){
        $estatus_venta = factory(App\EstatusVenta::class, 'nombrelargo')->make();
        $this->assertFalse($estatus_venta->isValid());
    }

}
