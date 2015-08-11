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
        $telefono = factory(App\Telefono::class)->create();
        factory(App\Domicilio::class)->create([
            'telefono_id' => $telefono->id
        ]);
        $domicilios = $telefono->domicilios;
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $domicilios);
        $this->assertInstanceOf('App\Domicilio', $domicilios[0]);
        $this->assertCount(1, $domicilios);
    }

}
