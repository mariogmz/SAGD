<?php

/**
 * @coversDefaultClass \App\EstadoRma
 */
class EstadoRmaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testNombreEsRequerido()
    {
        $estado_rma = factory(App\EstadoRma::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($estado_rma->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $estado_rma = factory(App\EstadoRma::class)->create();
        $estado_rma->nombre = 'Mary Poopings' . rand();
        $this->assertTrue($estado_rma->isValid('update'));
        $this->assertTrue($estado_rma->save());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsMaximo80Caracteres()
    {
        $estado_rma = factory(App\EstadoRma::class, 'nombrelargo')->make();
        $this->assertFalse($estado_rma->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsUnico()
    {
        $estado_rma1 = factory(App\EstadoRma::class)->create();
        $estado_rma2 = factory(App\EstadoRma::class)->make([
            'nombre' => $estado_rma1->nombre
        ]);
        $this->assertFalse($estado_rma2->isValid());
    }

    /**
     * @covers ::rmas
     * @group relaciones
     */
    public function testRmas()
    {
        $estado_rma = factory(App\EstadoRma::class)->create();
        $rmas = factory(App\Rma::class, 5)->create([
            'estado_rma_id' => $estado_rma->id
        ]);
        $estado_rma_resultado = $estado_rma->rmas;
        foreach ($estado_rma_resultado as $estadoRma)
        {
            $this->assertInstanceOf('App\Rma', $estadoRma);
        };

    }
}
