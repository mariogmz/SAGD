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
}