<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\SalidaDetalle
 */
class SalidaDetalleTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $sd = factory(App\SalidaDetalle::class)->make();
        $this->assertTrue($sd->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $this->setUpProducto();
        $this->setUpSalida();
        $detalle = $this->setUpDetalle();
        $detalle->cantidad = 1991;
        $this->assertTrue($detalle->isValid('update'));
        $this->assertTrue($detalle->save());
        $this->assertSame(1991, $detalle->cantidad);
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsObligatorio()
    {
        $sd = factory(App\SalidaDetalle::class)->make(['cantidad' => null]);
        $this->assertFalse($sd->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadTieneQueSerEntero()
    {
        $sd = factory(App\SalidaDetalle::class)->make(['cantidad' => 1991.5]);
        $this->assertFalse($sd->isValid());
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();
        $salida->cargar();
        $detalle = App\SalidaDetalle::last();

        $producto = $detalle->producto;
        $this->assertInstanceOf(App\Producto::class, $producto);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimiento()
    {
        $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();
        $salida->cargar();
        $detalle = App\SalidaDetalle::last();

        $pm = $detalle->productoMovimiento;
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pm);
    }

    /**
     * @covers ::salida
     * @group relaciones
     */
    public function testSalida()
    {
        $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();
        $salida->cargar();
        $detalle = App\SalidaDetalle::last();

        $salida = $detalle->salida;
        $this->assertInstanceOf(App\Salida::class, $salida);
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargar()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $this->assertTrue($detalle->cargar());
    }

    /**
     * @covers ::cargar
     * @group feature-salidas
     */
    public function testCargarInvalido()
    {
        $producto = $this->setUpProducto();
        $salida = $this->setUpSalida();
        $detalle = $this->setUpDetalle();

        $this->mock = Mockery::mock('App\Listeners\CrearProductoMovimientoDesdeSalida');
        $this->mock->shouldReceive([
            'handle' => [false]
        ])->withAnyArgs();
        $this->app->instance('App\Listeners\CrearProductoMovimientoDesdeSalida', $this->mock);

        $this->assertFalse($detalle->cargar());
    }

    private function setUpProducto()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);

        $productoSucursal = $producto->productosSucursales()->where('sucursal_id', $sucursal->id)->first();
        $productoSucursal->existencia()->create([
            'cantidad' => 100,
            'cantidad_apartado' => 0,
            'cantidad_pretransferencia' => 0,
            'cantidad_transferencia' => 0,
            'cantidad_garantia_cliente' => 0,
            'cantidad_garantia_zegucom' => 0
        ]);
        return $producto;
    }

    private function setUpSalida()
    {
        $this->setUpEstados();
        $sucursal = App\Sucursal::last();


        $salida = new App\Salida([
            'motivo' => 'Test',
            'empleado_id' => factory(App\Empleado::class)->create(['sucursal_id' => $sucursal->id])->id,
            'estado_salida_id' => App\EstadoSalida::creando()->id,
            'sucursal_id' => $sucursal->id
        ]);
        $salida->save();
        return $salida;
    }

    private function setUpDetalle($cantidad = 5)
    {
        $producto = App\Producto::last();
        $salida = App\Salida::last();

        $detalle = [
            'cantidad' => $cantidad,
            'producto_id' => $producto->id,
            'upc' => $producto->upc
        ];

        return $salida->crearDetalle($detalle);
    }

    private function setUpEstados()
    {
        $estadoSalidaCreando = new App\EstadoSalida(['nombre' => 'Creando']);
        $estadoSalidaCargando = new App\EstadoSalida(['nombre' => 'Cargando']);
        $estadoSalidaCargado = new App\EstadoSalida(['nombre' => 'Cargado']);

        $estadoSalidaCreando->save();
        $estadoSalidaCargando->save();
        $estadoSalidaCargado->save();
    }
}
