<?php

/**
 * @coversDefaultClass \App\Tabulador
 */
class TabuladorTest extends TestCase
{

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $tabulador = factory(App\Tabulador::class)->make();
        $this->assertTrue($tabulador->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $model = factory(App\Tabulador::class)->create();
        $model->cliente_id = 1;
        $this->assertTrue($model->isValid('update'));
        $this->assertTrue($model->save());
        $this->assertSame(1, $model->cliente_id);
    }

    /**
     * @coversNothing
     */
    public function testUsuarioEsRequerido()
    {
        $model = factory(App\Tabulador::class)->make(['cliente_id' => null]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalEsRequerido()
    {
        $model = factory(App\Tabulador::class)->make(['sucursal_id' => null]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTabuladorEsRequerido()
    {
        $model = factory(App\Tabulador::class)->make(['tabulador' => null]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTabuladorEsEntero()
    {
        $model = factory(App\Tabulador::class)->make(['tabulador' => 1.1]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTabuladorEsUnNumero()
    {
        $model = factory(App\Tabulador::class)->make(['tabulador' => "Tabulador1"]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHabilitadaDebeSerBooleano() {
        $model = factory(App\Tabulador::class)->make([
            'habilitada' => 'InvalidString'
        ]);
        $this->assertFalse($model->isValid());

        $model->habilitada = 0;
        $this->assertTrue($model->isValid());
        $model->habilitada = 1;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testExisteEnTabla()
    {
        $this->seeInDatabase('tabuladores', ['tabulador' => 1]);
        $this->seeInDatabase('tabuladores', ['tabulador' => 6]);
    }

    /**
     * @coversNothing
     */
    public function testNoExisteEnTabla()
    {
        $this->notSeeInDatabase('tabuladores', ['tabulador' => 0]);
        $this->notSeeInDatabase('tabuladores', ['tabulador' => 11]);
    }

    /**
     * @covers ::cliente
     * @group relaciones
     */
    public function testRelacionCliente()
    {
        $cliente = factory(App\Cliente::class)->create();
        $tabulador = factory(App\Tabulador::class)->create(['cliente_id' => $cliente->id, 'sucursal_id' => $cliente->sucursal_id]);
        $this->assertInstanceOf(App\Cliente::class, $tabulador->cliente);
        $this->assertEquals($cliente->id, $tabulador->cliente->id);
    }

    /**
     * @covers ::sucursales
     * @group relaciones
     */
    public function testRelacionSucursal()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $tabulador = factory(App\Tabulador::class)->create(['sucursal_id' => $sucursal->id]);
        $this->assertInstanceOf(App\Sucursal::class, $tabulador->sucursal);
        $this->assertEquals($sucursal->id, $tabulador->sucursal->id);
    }
}