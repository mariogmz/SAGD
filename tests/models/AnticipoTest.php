<?php

/**
 * @coversDefaultClass \App\Anticipo
 */
class AnticipoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testVentaEsRequerido() {
        $model = factory(App\Anticipo::class)->make([
            'venta_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testVentaEntregaNoEsRequerido() {
        $model = factory(App\Anticipo::class)->make([
            'venta_entrega_id' => null
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testConceptoEsRequerido() {
        $model = factory(App\Anticipo::class)->make([
            'concepto' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testConceptoEsMaximo50Caracteres() {
        $model = factory(App\Anticipo::class, 'conceptolargo')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMontoEsRequerido() {
        $model = factory(App\Anticipo::class)->make([
            'monto' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMontoEsDecimal() {
        $model = factory(App\Anticipo::class)->make([
            'monto' => 'Chewbacca'
        ]);
        $this->assertFalse($model->isValid(),'Monto debe ser inválido si su valor es un string');
        $model->monto = 10.00;
        $this->assertTrue($model->isValid(), 'Monto debe ser valido si su valor es numérico');
    }
    /**
     * @coversNothing
     */
    public function testCobradoEsRequerido() {
        $model = factory(App\Anticipo::class)->make([
            'cobrado' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCobradoDebeSerBooleano() {
        $model = factory(App\Anticipo::class)->make([
            'cobrado' => 'PushMe'
        ]);
        $this->assertFalse($model->isValid());
        $model->cobrado = 0;

        $this->assertTrue($model->isValid());
        $model->cobrado = 1;
        $this->assertTrue($model->isValid());
    }

    /**
     * @covers ::venta
     * @group relaciones
     */
    public function testVenta() {
        $parent = factory(App\Venta::class)->create();
        $child = factory(App\Anticipo::class)->create([
            'venta_id' => $parent->id
        ]);
        $parent_result = $child->venta;
        $this->assertInstanceOf('App\Venta', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::ventaEntrega
     * @group relaciones
     */
    public function testVentaEntrega() {
        $parent = factory(App\Venta::class)->create();
        $child = factory(App\Anticipo::class)->create([
            'venta_entrega_id' => $parent->id
        ]);
        $parent_result = $child->ventaEntrega;
        $this->assertInstanceOf('App\Venta', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }


}
