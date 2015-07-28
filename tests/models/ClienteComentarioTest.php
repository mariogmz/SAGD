<?php

/**
 * @coversDefaultClass \App\ClienteComentario
 */
class ClienteComentarioTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $cc = factory(App\ClienteComentario::class)->make();
        $this->assertTrue($cc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testComentarioEsRequerido()
    {
        $cc = factory(App\ClienteComentario::class)->make(['comentario' => null]);
        $this->assertFalse($cc->isValid());
    }

    /**
     * @coversNothing
     */
    public function testComentarioNoPuedeSerMayorDe200Caracteres()
    {
        $cc = factory(App\ClienteComentario::class, 'longcomment')->make();
        $this->assertFalse($cc->isValid());
    }
}
