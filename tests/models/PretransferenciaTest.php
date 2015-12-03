<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\Pretransferencia
 */
class PretransferenciaTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $pretransferencia = factory(App\Pretransferencia::class)->make();
        $this->assertTrue($pretransferencia->isValid());
    }

    /**
     * @covers ::producto
     * @group feature-transferencias
     */
    public function testProducto()
    {
        $pretransferencia = factory(App\Pretransferencia::class)->create();
        $producto = $pretransferencia->producto;
        $this->assertInstanceOf(App\Producto::class, $producto);
    }

    /**
     * @covers ::origen
     * @group feature-transferencias
     */
    public function testSucursalOrigen()
    {
        $pretransferencia = factory(App\Pretransferencia::class)->create();
        $origen = $pretransferencia->origen;
        $this->assertInstanceOf(App\Sucursal::class, $origen);
    }

    /**
     * @covers ::destino
     * @group feature-transferencias
     */
    public function testSucursalDestino()
    {
        $pretransferencia = factory(App\Pretransferencia::class)->create();
        $destino = $pretransferencia->destino;
        $this->assertInstanceOf(App\Sucursal::class, $destino);
    }
}
