<?php

use App\Telefono;

class TelefonoTest extends TestCase {

    public function testTelefonoValido(){
        $telefono = factory(Telefono::class)->make();
        $this->assertTrue($telefono->isValid());
    }

    public function testNumeroEsRequerido()
    {
        $telefono = factory(Telefono::class)->make([
            'numero' => ''
        ]);
        $this->assertFalse($telefono->isValid());
    }

    public function testTipoEsRequerido()
    {
        $telefono = factory(Telefono::class)->make([
            'tipo' => ''
        ]);
        $this->assertFalse($telefono->isValid());
    }

    public function testTelefonoUnico()
    {
        $telefono = factory(Telefono::class, 'mismonum', 3)->make();
        foreach ($telefono as $telefono)
        {
            $this->assertFalse($telefono->isValid());
        }
    }

}
