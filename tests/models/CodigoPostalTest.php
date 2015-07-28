<?php

/**
 * @coversDefaultClass \App\CodigoPostal
 */
class CodigoPostalTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testEstadoEsRequerido()
    {
        $codigo_postal = factory(App\CodigoPostal::class)->make([
            'estado' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testMunicipioEsRequerido()
    {
        $codigo_postal = factory(App\CodigoPostal::class)->make([
            'municipio' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalEsRequerido()
    {
        $codigo_postal = factory(App\CodigoPostal::class)->make([
            'codigo_postal' => ''
        ]);
        $this->assertFalse($codigo_postal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalNoContieneLetras()
    {
        $codigo_postal = factory(App\CodigoPostal::class)->make([
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
        $codigo_postal1 = factory(App\CodigoPostal::class)->create();
        $codigo_postal2 = factory(App\CodigoPostal::class)->make([
            'codigo_postal' => $codigo_postal1->codigo_postal
        ]);
        $this->assertFalse($codigo_postal2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalEsDe5Caracteres()
    {
        $codigo_postal = factory(App\CodigoPostal::class)->make();
        $this->assertTrue($codigo_postal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalEsCorrecto()
    {
        $codigo_postal = factory(App\CodigoPostal::class)->make();
        $this->assertTrue($codigo_postal->isValid());
    }

    /**
     * @covers ::domicilios
     */
    public function testDomicilios(){
        $codigo_postal = factory(App\CodigoPostal::class)->create();
        $domicilios = factory(App\Domicilio::class, 5)->create([
           'codigo_postal_id' => $codigo_postal->id
        ]);
        $domicilios_resultado = $codigo_postal->domicilios;
        for($i = 0; $i < 5; $i++){
            $this->assertEquals($domicilios[$i],$domicilios_resultado[$i]);
        }
    }

}
