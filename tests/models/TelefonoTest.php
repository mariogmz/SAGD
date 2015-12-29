<?php

use App\Telefono;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\Telefono
 */

class TelefonoTest extends TestCase {
    use DatabaseTransactions;
    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $telefono = factory(App\Telefono::class)->create();
        $telefono->tipo = 'MC Hammer';
        $this->assertTrue($telefono->isValid('update'));
        $this->assertTrue($telefono->save());
    }

    /**
     * @coversNothing
     */
    public function testTelefonoValido() {
        $telefono = factory(Telefono::class)->make();
        $this->assertTrue($telefono->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroEsRequerido() {
        $telefono = factory(Telefono::class)->make([
            'numero' => ''
        ]);
        $this->assertFalse($telefono->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDomicilioEsRequerido() {
        $model = factory(App\Telefono::class)->make([
            'domicilio_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoEsRequerido() {
        $telefono = factory(Telefono::class)->make([
            'tipo' => ''
        ]);
        $this->assertFalse($telefono->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTelefonoUnico() {
        $telefono1 = factory(Telefono::class)->create();
        $telefono2 = factory(Telefono::class)->make([
            'numero' => $telefono1->numero
        ]);
        $this->assertFalse($telefono2->isValid());
    }

    /**
     * @covers ::domicilio
     * @group relaciones
     */
    public function testDomicilio() {
        $parent = factory(App\Domicilio::class)->create();
        $child = factory(App\Telefono::class)->create([
            'domicilio_id' => $parent->id
        ]);
        $parent_result = $child->domicilio;
        $this->assertInstanceOf('App\Domicilio', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }
}
