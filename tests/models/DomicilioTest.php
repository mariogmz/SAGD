<?php

use App\Domicilio;

class DomicilioTest extends TestCase {

    public function testDomicilioEsValido()
    {
        $domicilio = factory(Domicilio::class)->make();
        $this->assertTrue($domicilio->isValid());
    }

    public function testCalleEsRequerida()
    {
        $domicilio = factory(Domicilio::class)->make([
            'calle' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    public function testLocalidadEsRequerida()
    {
        $domicilio = factory(Domicilio::class)->make([
            'localidad' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    public function testCodigoPostalAsociadoEsRequerido()
    {
        $domicilio = factory(Domicilio::class)->make([
            'codigo_postal_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    public function testTelefonoAsociadoEsRequerido()
    {
        $domicilio = factory(Domicilio::class)->make([
            'telefono_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }
}
