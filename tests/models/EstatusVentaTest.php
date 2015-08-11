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

    /**
     * @covers ::ventas
     * @group relaciones
     */
    public function testVentas() {
        $parent = factory(App\EstatusVenta::class)->create();
        factory(App\Venta::class)->create([
            'estatus_venta_id' => $parent->id
        ]);
        $children = $parent->ventas;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Venta', $children[0]);
        $this->assertCount(1, $children);
    }

    /**
     * @covers ::ventasMovimientos
     * @group relaciones
     */
    public function testVentasMovimientos() {
        $parent = factory(App\EstatusVenta::class)->create();
        factory(App\VentaMovimiento::class)->create([
            'estatus_venta_id' => $parent->id
        ]);
        $children = $parent->ventasMovimientos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\VentaMovimiento', $children[0]);
        $this->assertCount(1, $children);
    }


}
