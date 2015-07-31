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
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $cc = factory(App\ClienteComentario::class, 'full')->create();
        $cc->comentario = 'MC Hammer';
        $this->assertTrue($cc->isValid('update'));
        $this->assertTrue($cc->save());
        $this->assertSame('MC Hammer', $cc->comentario);
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
     * @group relaciones
     */
    public function testCliente()
    {
        $cc = factory(App\ClienteComentario::class,'full')->create();
        $cliente = $cc->cliente;
        $this->assertInstanceOf(App\Cliente::class, $cliente);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado()
    {
        $cc = factory(App\ClienteComentario::class, 'full')->create();
        $empleado = $cc->empleado;
        $this->assertInstanceOf(App\Empleado::class, $empleado);
    }
}
