<?php

/**
 * @coversDefaultClass \App\Corte
 */
class CorteTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testCorteTieneTimestamps() {
        $corte = factory(App\Corte::class)->create();
        $this->assertNotEmpty($corte->timestamps);
    }

    /**
     * @coversNothing
     */
    public function testFondoEsRequerido() {
        $model = factory(App\Corte::class)->make([
            'fondo' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFondoEsDecimal() {
        $model = factory(App\Corte::class)->make([
            'fondo' => 'ILikeTrains'
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFondoReportadoNoEsRequerido() {
        $model = factory(App\Corte::class)->make([
            'fondo_reportado' => 1.00
        ]);
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFondoReportadoEsDecimal() {
        $model = factory(App\Corte::class)->make([
            'fondo_reportado' => 'MyNameIsPotatoe'
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCajaNoRequerido() {
        $model = factory(App\Corte::class)->make([
            'caja_id' => null
        ]);
        $this->assertTrue($model->isValid());
    }


    /**
     * @coversNothing
     */
    public function testEmpleadoEsRequerido() {
        $model = factory(App\Corte::class)->make([
            'empleado_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCorteGlobalNoRequerido() {
        $model = factory(App\Corte::class)->make([
            'corte_global_id' => null
        ]);
        $this->assertTrue($model->isValid());
    }


    /**
     * @covers ::caja
     * @group relaciones
     */
    public function testCaja() {
        $caja = factory(App\Caja::class)->create();
        $corte = factory(App\Corte::class)->create([
            'caja_id' => $caja->id
        ]);
        $caja_resultado = $corte->caja;
        $this->assertInstanceOf('App\Caja', $caja_resultado);
        $this->assertSame($caja->id, $caja_resultado->id);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado() {
        $empleado = factory(App\Empleado::class)->create();
        $corte = factory(App\Corte::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $empleado_resultado = $corte->empleado;
        $this->assertInstanceOf('App\Empleado', $empleado_resultado);
        $this->assertSame($empleado->id, $empleado_resultado->id);
    }

    /**
     * @covers ::corteGlobal
     * @group relaciones
     */
    public function testCorteGlobal() {
        $corte_global = factory(App\Corte::class, 'global')->create();
        $corte = factory(App\Corte::class)->create([
            'corte_global_id' => $corte_global->id
        ]);
        $corte_global_resultado = $corte->corteGlobal;
        $this->assertInstanceOf('App\Corte', $corte_global_resultado);
        $this->assertSame($corte_global->id, $corte_global_resultado->id);
    }

    /**
     * @covers ::cortes
     * @group relaciones
     */
    public function testCortes() {
        $corte_global = factory(App\Corte::class, 'global')->create();
        factory(App\Corte::class)->create([
            'corte_global_id' => $corte_global->id
        ]);
        $cortes = $corte_global->cortes;
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $cortes);
        $this->assertInstanceOf('App\Corte', $cortes[0]);
        $this->assertSame($corte_global->id, $cortes[0]->corte_global_id);
    }

    /**
     * @covers ::gastosExtras
     * @group relaciones
     */
    public function testGastosExtras() {
        $corte = factory(App\Corte::class)->create();
        factory(App\GastoExtra::class)->create([
            'corte_id' => $corte->id
        ]);
        $gastos_extras = $corte->gastosExtras;
        $this->assertCount(1, $gastos_extras);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $gastos_extras);
        $this->assertInstanceOf('App\GastoExtra', $gastos_extras[0]);
        $this->assertSame($corte->id, $gastos_extras[0]->corte_id);
    }

}
