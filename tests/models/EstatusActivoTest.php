<?php

/**
 * @coversDefaultClass \App\EstatusActivo
 */
class EstatusActivoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testEstatusEsRequerido() {
        $estatus_activo = factory(App\EstatusActivo::class)->make([
            'estatus' => null
        ]);
        $this->assertFalse($estatus_activo->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEstatusEsMaximo45Caracteres() {
        $estatus_activo = factory(App\EstatusActivo::class, 'estatuslargo')->make();
        $this->assertFalse($estatus_activo->isValid());
    }

    /**
     * @covers ::metodosPagos
     */
    public function testMetodosPagos() {
        $estatus_activo = factory(App\EstatusActivo::class)->create();
        factory(App\MetodoPago::class, 5)->create([
            'estatus_activo_id' => $estatus_activo->id
        ]);
        $metodos_pagos_resultado = $estatus_activo->metodosPagos;
        foreach ($metodos_pagos_resultado as $mp) {
            $this->assertInstanceOf('App\MetodoPago', $mp);
            $this->assertSame($estatus_activo->id, $mp->estatus_activo_id);
        }

    }

    /**
     * @covers ::guias
     * @group relaciones
     */
    public function testGuias()
    {
        $estatus_activo = factory(App\EstatusActivo::class)->create();
        factory(App\Guia::class, 'full')->create([
            'estatus_activo_id' => $estatus_activo->id
        ]);
        $guias = $estatus_activo->guias;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $guias);
        $this->assertInstanceOf(App\Guia::class, $guias[0]);
        $this->assertCount(1, $guias);
    }
}
