<?php

/**
 * @coversDefaultClass \App\Rma
 */
class RmaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testEstadoRmaRequerido() {
        $rma = factory(App\Rma::class)->make([
            'cliente_id' => null
        ]);
        $this->assertFalse($rma->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClienteRequerido() {
        $rma = factory(App\Rma::class)->make([
            'cliente_id' => null
        ]);
        $this->assertFalse($rma->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmpleadoRequerido() {
        $rma = factory(App\Rma::class)->make([
            'empleado_id' => null
        ]);
        $this->assertFalse($rma->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTiempoRmaRequerido() {
        $rma = factory(App\Rma::class)->make([
            'rma_tiempo_id' => null
        ]);
        $this->assertFalse($rma->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalRequerido() {
        $rma = factory(App\Rma::class)->make([
            'sucursal_id' => null
        ]);
        $this->assertFalse($rma->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNotaCreditoNoRequerido() {
        $rma = factory(App\Rma::class, 'sinnotacredito')->make();
        $this->assertTrue($rma->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $model = factory(App\Rma::class)->make();
        if(!$model->isValid()) print_r($model);
        $this->assertTrue($model->save());
        $model->estado_rma_id = factory(App\EstadoRma::class)->create()->id;
        $this->assertTrue($model->isValid());
        $this->assertTrue($model->save());
    }

    /**
     * @covers ::estadoRma
     * @group relaciones
     */
    public function testEstadoRma() {
        $estado_rma = factory(App\EstadoRma::class)->create();
        $rma = factory(App\Rma::class)->create([
            'estado_rma_id' => $estado_rma->id
        ]);
        $this->assertInstanceOf('App\EstadoRma', $rma->estadoRma);
    }

    /**
     * @covers ::cliente
     * @group relaciones
     */
    public function testCliente() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $rma = factory(App\Rma::class)->create([
            'cliente_id' => $cliente->id
        ]);
        $this->assertEquals(App\Cliente::find($cliente->id), $rma->cliente);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado() {
        $empleado = factory(App\Empleado::class)->create();
        $rma = factory(App\Rma::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $this->assertEquals(App\Empleado::find($empleado->id), $rma->empleado);
    }

    /**
     * @covers ::rmaTiempo
     * @group relaciones
     */
    public function testRmaTiempo() {
        $parent = factory(App\RmaTiempo::class)->create();
        $child = factory(App\Rma::class)->create([
            'rma_tiempo_id' => $parent->id
        ]);
        $parent_result = $child->rmaTiempo;
        $this->assertInstanceOf('App\RmaTiempo', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::rmasDetalles
     * @group relaciones
     */
    public function testRmasDetalles() {
        $parent = factory(App\Rma::class)->create();
        factory(App\RmaDetalle::class)->create([
            'rma_id' => $parent->id
        ]);
        $children = $parent->rmasDetalles;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\RmaDetalle', $children[0]);
        $this->assertCount(1, $children);
    }


    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal() {
        $sucursal = factory(App\Sucursal::class)->create();
        $rma = factory(App\Rma::class)->create([
            'sucursal_id' => $sucursal->id
        ]);
        $this->assertEquals(App\Sucursal::find($sucursal->id), $rma->sucursal);
    }

    /**
     * @covers ::notaCredito
     * @group relaciones
     */
    public function testNotaCredito() {
        $nota_credito = factory(App\NotaCredito::class, 'full')->create();
        $rma = factory(App\Rma::class)->create([
            'nota_credito_id' => $nota_credito->id
        ]);
        $this->assertEquals(App\NotaCredito::find($nota_credito->id), $rma->notaCredito);
    }
}
