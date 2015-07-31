<?php

/**
 * @coversDefaultClass \App\PaginaWebDistribuidor
 */
class PaginaWebDistribuidorTest extends TestCase {

    protected $pwd;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $pwd = factory(App\PaginaWebDistribuidor::class)->make();
        $this->assertTrue($pwd->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $pwd = factory(App\PaginaWebDistribuidor::class)->create(['cliente_id' => $cliente->id]);
        $pwd->url = 'MC Hammer';
        $this->assertTrue($pwd->isValid('update'));
        $this->assertTrue($pwd->save());
        $this->assertSame('MC Hammer', $pwd->url);
    }

    /**
     * @coversNothing
     */
    public function testActivoEsRequerido()
    {
        $pwd = factory(App\PaginaWebDistribuidor::class)->make(['activo' => null]);
        $this->assertFalse($pwd->isValid());
    }

    /**
     * @coversNothing
     */
    public function testActivoEsBooleano()
    {
        $pwd = factory(App\PaginaWebDistribuidor::class)->make(['activo' => 'a']);
        $this->assertFalse($pwd->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaVencimientoEsTimestamp()
    {
        $pwd = factory(App\PaginaWebDistribuidor::class)->make(['fecha_vencimiento' => 'aaa']);
        $this->assertFalse($pwd->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaVencimientoEsRequerido()
    {
        $pwd = factory(App\PaginaWebDistribuidor::class)->make(['fecha_vencimiento' => null]);
        $this->assertFalse($pwd->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUrlPuedeSerNula()
    {
        $pwd = factory(App\PaginaWebDistribuidor::class)->make(['url' => null]);
        $this->assertTrue($pwd->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUrlNoPuedeSerMasDe100Caracteres()
    {
        $pwd = factory(App\PaginaWebDistribuidor::class, 'longurl')->make();
        $this->assertFalse($pwd->isValid());
    }

    /**
     * @covers ::cliente
     * @group relaciones
     */
    public function testCliente()
    {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $pwd = factory(App\PaginaWebDistribuidor::class)->create(['cliente_id' => $cliente->id]);
        $cliente = $pwd->cliente;
        $this->assertInstanceOf(App\Cliente::class, $cliente);
    }
}
