<?php

use App\Telefono;

class TelefonoTest extends TestCase {

    public function testTelefonoValido()
    {
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
        $telefonos_unicos = factory(Telefono::class, 10)->make();
        $telefonos_nounicos = factory(Telefono::class, 'mismonum', 10)->make();
        for ($i = 0; $i < 10; $i ++)
        {
            $this->assertTrue($telefonos_unicos[$i]->save());
            if (!$i)
            {
                $telefonos_nounicos[$i]->save();
            } else
            {
                $this->assertFalse($telefonos_nounicos[$i]->save());
            }
        }
    }

}
