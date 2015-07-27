<?php

use App\Telefono;

class TelefonoTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testTelefonoValido()
    {
        $telefono = factory(Telefono::class)->make();
        $this->assertTrue($telefono->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroEsRequerido()
    {
        $telefono = factory(Telefono::class)->make([
            'numero' => ''
        ]);
        $this->assertFalse($telefono->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTipoEsRequerido()
    {
        $telefono = factory(Telefono::class)->make([
            'tipo' => ''
        ]);
        $this->assertFalse($telefono->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTelefonoUnico()
    {
        $telefono1 = factory(Telefono::class)->create();
        $telefono2 = factory(Telefono::class)->make([
            'numero' => $telefono1->numero
        ]);
        $this->assertFalse($telefono2->isValid());
    }

}
