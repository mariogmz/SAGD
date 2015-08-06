<?php

/**
 * @coversDefaultClass \App\Zona
 */
class ZonaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $zona = factory(App\Zona::class)->make();
        $this->assertTrue($zona->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $zona = factory(App\Zona::class)->create();
        $zona->km_maximos = 1991.0;
        $this->assertTrue($zona->isValid('update'));
        $this->assertTrue($zona->save());
        $this->assertSame(1991.0, $zona->km_maximos);
    }

    /**
     * @coversNothing
     */
    public function testClaveEsObligatoria()
    {
        $zona = factory(App\Zona::class)->make(['clave' => null]);
        $this->assertFalse($zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveSeGuardaEnMayusculas()
    {
        $zona = factory(App\Zona::class)->make();
        $clave = strtolower($zona->clave);
        $zona->clave = $clave;
        $this->assertTrue($zona->isValid());
        $this->assertTrue($zona->save());
        $this->assertSame(strtoupper($clave), $zona->clave);
    }

    /**
     * @coversNothing
     */
    public function testClaveEsDeMaximo6Digitos()
    {
        $zona = factory(App\Zona::class)->make(['clave' => 'AAAAAAA']);
        $this->assertFalse($zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnica()
    {
        $zona = factory(App\Zona::class)->make();
        $zona_dup = clone $zona;
        $zona->save();
        $this->assertFalse($zona_dup->isValid());
    }

    /**
     * @coversNothing
     */
    public function testKmMaximosEsObligatorio()
    {
        $zona = factory(App\Zona::class)->make(['km_maximos' => null]);
        $this->assertFalse($zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testKmMaximosEsDecimal()
    {
        $zona = factory(App\Zona::class)->make(['km_maximos' => 'null']);
        $this->assertFalse($zona->isValid());
    }

    /**
     * @coversNothing
     */
    public function testKmMaximosEsPositivo()
    {
        $zona = factory(App\Zona::class)->make(['km_maximos' => -1.0]);
        $this->assertFalse($zona->isValid());
    }


}
