<?php

/**
 * @coversDefaultClass \App\Galeria
 */
class GaleriaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testFichaIdEsRequerido() {
        $galeria = factory(App\Galeria::class)->make();
        $ficha_id = $galeria->ficha_id;
        unset($galeria->ficha_id);
        $this->assertFalse($galeria->isValid());
        $galeria->ficha_id = $ficha_id;
        $this->assertTrue($galeria->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPrincipalEsBooleano() {
        $galeria = factory(App\Galeria::class)->make([
            'principal' => 'hola'
        ]);
        $this->assertFalse($galeria->isValid());
        $galeria->principal = false;
        $this->assertTrue($galeria->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPrincipalEsDefaultFalso() {
        $galeria = factory(App\Galeria::class)->make();
        $this->assertTrue($galeria->save());
        $this->assertFalse(boolval($galeria->fresh()->principal));
    }

    /**
     * @coversNothing
     */
    public function testImagenEsUnAttachment() {
        $galeria = factory(App\Galeria::class)->make();
        $this->assertTrue($galeria->save());
        $this->assertFileExists($galeria->imagen->path('original'));
    }

    /**
     * @coversNothing
     */
    public function testUnaGaleriaSoloTieneUnaImagenPrincipal() {
        $galeria = factory(App\Galeria::class, 'principal')->create();
        $galeria_test = factory(App\Galeria::class, 'principal')->make([
            'ficha_id' => $galeria->ficha_id
        ]);
        $this->assertFalse($galeria_test->isValid());
        $galeria_test->principal = false;
        $this->assertTrue($galeria_test->isValid());
    }

    /**
     * @covers ::ficha
     */
    public function testFicha() {
        $ficha = factory(App\Producto::class)->create()->ficha;
        $galeria = factory(App\Galeria::class)->create([
            'ficha_id' => $ficha->id
        ]);
        $this->assertInstanceOf(App\Ficha::class, $galeria->ficha);
        $this->assertSame($ficha->id, $galeria->ficha->id);
    }
}
