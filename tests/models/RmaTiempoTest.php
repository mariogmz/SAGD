<?php

/**
 * @coversDefaultClass \App\RmaTiempo
 */
class RmaTiempoTest extends TestCase {


    /**
     * @coversNothing
     */
    public function testNombreEsRequerido() {
        $model = factory(App\RmaTiempo::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsUnico() {
        $model1 = factory(App\RmaTiempo::class)->create();
        $model2 = factory(App\RmaTiempo::class)->make([
            'nombre' => $model1->nombre
        ]);
        $this->assertFalse($model2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRmaEsMaximoDe45Caracteres() {
        $model = factory(App\RmaTiempo::class, 'nombrelargo')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testModeloEsActualizable() {
        $model = factory(App\RmaTiempo::class)->create();
        $model->nombre = 'JohnPetrucci' . rand(); // When I play guitar... people die
        $this->assertTrue($model->save());
    }

    /**
     * @covers ::rmas
     * @group relaciones
     */
    public function testRmas() {
        $parent = factory(App\RmaTiempo::class)->create();
        factory(App\Rma::class)->create([
            'rma_tiempo_id' => $parent->id
        ]);
        $children = $parent->rmas;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Rma', $children[0]);
        $this->assertCount(1, $children);
    }

}
