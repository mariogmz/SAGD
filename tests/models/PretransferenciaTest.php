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

    /**
     * @covers ::empleado
     * @group feature-transferencias
     */
    public function testEmpleado()
    {
        $pretransferencia = factory(App\Pretransferencia::class)->create();
        $empleado = $pretransferencia->empleado;
        $this->assertInstanceOf(App\Empleado::class, $empleado);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testTransferirCambiaLosEstadosDeLasPretransferencias()
    {
        $data = $this->setUpData();
        $blank = new App\Pretransferencia;

        $blank->transferir($data['origen'], $data['destino']);

        $pretransferencias = App\Pretransferencia::all();

        $this->assertEquals(App\EstadoPretransferencia::transferido(), $pretransferencias->first()->estado->id);
    }

    private function setUpData()
    {
        App\EstadoPretransferencia::create(['nombre' => 'Sin Transferir']);
        App\EstadoPretransferencia::create(['nombre' => 'Transferido']);

        $origen = factory(App\Sucursal::class)->create();
        $destino = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $empleado = factory(App\Empleado::class)->create();

        App\Pretransferencia::create([
            'cantidad' => 10,
            'producto_id' => $producto->id,
            'sucursal_origen_id' => $origen->id,
            'sucursal_destino_id' => $destino->id,
            'empleado_id' => $empleado->id,
            'estado_pretransferencia_id' => App\EstadoPretransferencia::sinTransferir()
        ]);
        App\Pretransferencia::create([
            'cantidad' => 10,
            'producto_id' => $producto->id,
            'sucursal_origen_id' => $origen->id,
            'sucursal_destino_id' => $destino->id,
            'empleado_id' => $empleado->id,
            'estado_pretransferencia_id' => App\EstadoPretransferencia::sinTransferir()
        ]);

        return [
            'origen' => $origen->id,
            'destino' => $destino->id,
            'producto' => $producto->id,
            'empleado' => $empleado->id,
        ];
    }
}
