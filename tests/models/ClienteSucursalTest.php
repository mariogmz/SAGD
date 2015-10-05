<?php

/**
 * @coversDefaultClass \App\ClienteSucursal
 */
class ClienteSucursalTest extends TestCase
{

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $clienteSucursal = factory(App\ClienteSucursal::class)->make();
        $this->assertTrue($clienteSucursal->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $model = factory(App\ClienteSucursal::class)->create();
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
        $model = factory(App\ClienteSucursal::class)->make(['cliente_id' => null]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalEsRequerido()
    {
        $model = factory(App\ClienteSucursal::class)->make(['sucursal_id' => null]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTabuladorEsRequerido()
    {
        $model = factory(App\ClienteSucursal::class)->make(['tabulador' => null]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTabuladorEsEntero()
    {
        $model = factory(App\ClienteSucursal::class)->make(['tabulador' => 1.1]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTabuladorEsUnNumero()
    {
        $model = factory(App\ClienteSucursal::class)->make(['tabulador' => "Tabulador1"]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHabilitadaDebeSerBooleano() {
        $model = factory(App\ClienteSucursal::class)->make([
            'habilitada' => 'InvalidString'
        ]);
        $this->assertFalse($model->isValid());

        $model->habilitada = 0;
        $this->assertTrue($model->isValid());
        $model->habilitada = 1;
        $this->assertTrue($model->isValid());
    }

    /**
     * @covers ::cliente
     * @group relaciones
     */
    public function testRelacionCliente()
    {
        $clienteSucursal = factory(App\ClienteSucursal::class)->create();
        $cliente = $clienteSucursal->cliente_id;
        $this->assertInstanceOf(App\Cliente::class, $cliente);
    }


}