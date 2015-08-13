<?php

use App\Telefono;

class TelefonoTest extends TestCase {

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
     * @covers ::domicilios
     * @group relaciones
     */
    public function testDomicilios() {
        $parent = factory(App\Domicilios::class)->create();
        $child = factory(App\Telefono::class)->create([
            'domicilios_id' => $parent->id
        ]);
        $parent_result = $child->domicilios;
        $this->assertInstanceOf('App\Domicilios', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }
}
