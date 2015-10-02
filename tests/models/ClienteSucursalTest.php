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
        $cr = factory(App\ClienteSucursal::class)->create();
        $cr->tabulador = '10';
        $this->assertTrue($cr->isValid('update'));
        $this->assertTrue($cr->save());
        $this->assertSame('10', $cr->tabulador);
    }

    /**
     * @coversNothing
     */
    public function testUsuarioEsObligatorio()
    {
        //$clienteSucursal = factory(App\ClienteSucursal::class)->make(['usuario_id' => null]);
        //$this->assertFalse($clienteSucursal->isValid());
    }

}