<?php

use App\CodigoPostal;

class CodigoPostalTest extends TestCase {

    public function testEstadoEsRequerido()
    {
        $codigo_postal = factory(CodigoPostal::class)->make([
            'estado' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    public function testMunicipioEsRequerido()
    {
        $codigo_postal = factory(CodigoPostal::class)->make([
            'municipio' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    public function testCodigoPostalEsRequerido()
    {
        $codigo_postal = factory(CodigoPostal::class)->make([
            'codigo_postal' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    public function testCodigoPostalNoContieneLetras()
    {
        $codigo_postal = factory(CodigoPostal::class)->make([
            'codigo_postal' => 'ASCBD'
        ]);
        $this->assertFalse($codigo_postal->isValid());
        $codigo_postal->codigo_postal = '20000';
        $this->assertTrue($codigo_postal->isValid());
    }


    public function testCodigoPostalEsUnico()
    {
        $codigo_postal = factory(CodigoPostal::class, 5)->make();
        foreach ($codigo_postal as $cp)
        {
            $this->assertTrue($cp->isValid());
        }
    }

    public function testCodigoPostalEsDe5Caracteres()
    {
        $codigo_postal = factory(CodigoPostal::class)->make();
        $this->assertTrue($codigo_postal->isValid());
    }

    public function testCodigoPostalEsCorrecto()
    {
        $codigo_postal = factory(CodigoPostal::class)->make();
        $this->assertTrue($codigo_postal->isValid());
    }

}
