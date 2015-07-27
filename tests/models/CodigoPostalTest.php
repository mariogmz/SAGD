<?php

use App\CodigoPostal;

class CodigoPostalTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testEstadoEsRequerido()
    {
        $codigo_postal = factory(CodigoPostal::class)->make([
            'estado' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMunicipioEsRequerido()
    {
        $codigo_postal = factory(CodigoPostal::class)->make([
            'municipio' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalEsRequerido()
    {
        $codigo_postal = factory(CodigoPostal::class)->make([
            'codigo_postal' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalNoContieneLetras()
    {
        $codigo_postal = factory(CodigoPostal::class)->make([
            'codigo_postal' => 'ASCBD'
        ]);
        $this->assertFalse($codigo_postal->isValid());
        $codigo_postal->codigo_postal = '20000';
        $this->assertTrue($codigo_postal->isValid());
    }


    /**
     * @coversNothing
     */
    public function testCodigoPostalEsUnico()
    {
        $codigo_postal1 = factory(CodigoPostal::class)->create();
        $codigo_postal2 = factory(CodigoPostal::class)->make([
            'codigo_postal' => $codigo_postal1->codigo_postal
        ]);
        $this->assertFalse($codigo_postal2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalEsDe5Caracteres()
    {
        $codigo_postal = factory(CodigoPostal::class)->make();
        $this->assertTrue($codigo_postal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalEsCorrecto()
    {
        $codigo_postal = factory(CodigoPostal::class)->make();
        $this->assertTrue($codigo_postal->isValid());
    }

}
