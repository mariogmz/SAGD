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

    /**
     * @covers ::cliente
     */
    public function testCliente()
    {
        $cc = factory(App\ClienteComentario::class,'full')->create();
        $cliente = $cc->cliente;
        $this->assertInstanceOf(App\Cliente::class, $cliente);
    }

    /**
     * @covers ::empleado
     */
    public function testEmpleado()
    {
        $cc = factory(App\ClienteComentario::class, 'full')->create();
        $empleado = $cc->empleado;
        $this->assertInstanceOf(App\Empleado::class, $empleado);
    }
}
