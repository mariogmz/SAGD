<?php

use App\Domicilio;

class DomicilioTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDomicilioEsValido()
    {
        $domicilio = factory(Domicilio::class)->make();
        $this->assertTrue($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCalleEsRequerida()
    {
        $domicilio = factory(Domicilio::class)->make([
            'calle' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLocalidadEsRequerida()
    {
        $domicilio = factory(Domicilio::class)->make([
            'localidad' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalAsociadoEsRequerido()
    {
        $domicilio = factory(Domicilio::class)->make([
            'codigo_postal_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTelefonoAsociadoEsRequerido()
    {
        $domicilio = factory(Domicilio::class)->make([
            'telefono_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }
}
