<?php

/**
 * @coversDefaultClass \App\Sucursal
 */
class SucursalTest extends TestCase {

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $sucursal = factory(App\Sucursal::class)->create();
        $sucursal->nombre = 'Arcadia';
        $this->assertTrue($sucursal->isValid('update'));
        $this->assertTrue($sucursal->save());
    }

    /**
     * @coversNothing
     */
    public function testClaveDebeSerDe8CaracteresAlfa() {
        $sucursal = factory(App\Sucursal::class)->make();
        $this->assertTrue($sucursal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveDebeSerUnica() {
        $sucursal1 = factory(App\Sucursal::class)->create();
        $sucursal2 = factory(App\Sucursal::class)->make([
            'clave' => $sucursal1->clave
        ]);
        $this->assertFalse($sucursal2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreDebeExistir() {
        $sucursal = factory(App\Sucursal::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($sucursal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHorariosDebeExistir() {
        $sucursal = factory(App\Sucursal::class)->make([
            'horarios' => ''
        ]);
        $this->assertFalse($sucursal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalValida() {
        $sucursal = $sucursal = factory(App\Sucursal::class)->make();
        $this->assertTrue($sucursal->isValid());
    }

    /**
     * @covers ::proveedor
     * @group relaciones
     */
    public function testProveedor() {
        $proveedor = factory(App\Proveedor::class)->create();
        $sucursal = factory(App\Sucursal::class)->make([
            'proveedor_id' => $proveedor->id
        ]);
        $this->assertEquals($proveedor->id, $sucursal->proveedor->id);
    }

    /**
     * @covers ::domicilio
     * @group relaciones
     */
    public function testDomicilio() {
        $domicilio = factory(App\Domicilio::class)->create();
        $sucursal = factory(App\Sucursal::class)->create([
            'domicilio_id' => $domicilio->id
        ]);
        $this->assertEquals($domicilio->id, $sucursal->domicilio->id);
    }

    /**
     * @covers ::productos
     * @group relaciones
     */
    public function testProductos() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $testProductos = $sucursal->productos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $testProductos);
        $this->assertInstanceOf(App\Producto::class, $testProductos[0]);
    }

    /**
     * @covers ::rmas
     * @group relaciones
     */
    public function testRmas() {
        $sucursal = factory(App\Sucursal::class)->create();
        factory(App\Rma::class)->create([
            'sucursal_id' => $sucursal->id
        ]);
        $rmas_resultados = $sucursal->rmas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rmas_resultados);
        foreach ($rmas_resultados as $rr) {
            $this->assertInstanceOf(App\Rma::class, $rr);
        }
    }

    /**
     * @covers ::salidas
     * @group relaciones
     */
    public function testSalidas() {
        $sucursal = factory(App\Sucursal::class)->create();
        $salida = factory(App\Salida::class, 'full')->create(['sucursal_id' => $sucursal->id]);
        $salidas = $sucursal->salidas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $salidas);
        $this->assertInstanceOf(App\Salida::class, $salidas[0]);
        $this->assertCount(1, $salidas);
    }

    /**
     * @covers ::razonesSocialesEmisores
     * @group relaciones
     */
    public function testRazonesSocialesEmisores() {
        $sucursal = factory(App\Sucursal::class)->create();
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create(['sucursal_id' => $sucursal->id]);
        $rses = $sucursal->razonesSocialesEmisores;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rses);
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $rses[0]);
        $this->assertCount(1, $rses);
    }

    /**
     * @covers ::entradasDetalles
     * @group relaciones
     */
    public function testEntradasDetalles() {
        $sucursal = factory(App\Sucursal::class)->create();
        $ed = factory(App\EntradaDetalle::class, 'full')->create(['sucursal_id' => $sucursal->id]);
        $eds = $sucursal->entradasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $eds);
        $this->assertInstanceOf(App\EntradaDetalle::class, $eds[0]);
        $this->assertCount(1, $eds);
    }

    /**
     * @covers ::transferenciasOrigen
     * @group relaciones
     */
    public function testTransferenciasOrigen() {
        $sucursal = factory(App\Sucursal::class)->create();
        $transfer = factory(App\Transferencia::class, 'full')->create(['sucursal_origen_id' => $sucursal->id]);
        $tso = $sucursal->transferenciasOrigen;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $tso);
        $this->assertInstanceOf(App\Transferencia::class, $tso[0]);
        $this->assertCount(1, $tso);
    }

    /**
     * @covers ::transferenciasDestino
     * @group relaciones
     */
    public function testTransferenciasDestino() {
        $sucursal = factory(App\Sucursal::class)->create();
        $transfer = factory(App\Transferencia::class, 'full')->create(['sucursal_destino_id' => $sucursal->id]);
        $tsd = $sucursal->transferenciasDestino;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $tsd);
        $this->assertInstanceOf(App\Transferencia::class, $tsd[0]);
        $this->assertCount(1, $tsd);
    }

    /**
     * @covers ::apartados
     * @group relaciones
     */
    public function testApartados() {
        $sucursal = factory(App\Sucursal::class)->create();
        $apartado = factory(App\Apartado::class, 'full')->create(['sucursal_id' => $sucursal->id]);
        $apartados = $sucursal->apartados;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $apartados);
        $this->assertInstanceOf(App\Apartado::class, $apartados[0]);
        $this->assertCount(1, $apartados);
    }

    /**
     * @covers ::cajas
     * @group relaciones
     */
    public function testCajas() {
        $sucursal = factory(App\Sucursal::class)->create();
        factory(App\Caja::class)->create([
            'sucursal_id' => $sucursal->id
        ]);
        $cajas = $sucursal->cajas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $cajas);
        $this->assertInstanceOf(App\Caja::class, $cajas[0]);
        $this->assertCount(1, $cajas);
    }

    /**
     * @covers ::precio
     * @group relaciones
     */
    public function testPrecio() {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        factory(App\Precio::class)->create(['producto_sucursal_id' => App\ProductoSucursal::last()->id]);

        $this->assertInstanceOf(App\Precio::class, $sucursal->precio($producto));
    }

    /**
     * @covers ::movimientos
     * @group relaciones
     * @group movimientos
     */
    public function testMovimientos() {
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $sucursal = $pm->productoSucursal->sucursal;
        $pms = $sucursal->movimientos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pms);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pms[0]);
    }

    /**
     * @covers ::movimientos
     * @group relaciones
     * @group movimientos
     */
    public function testMovimientosConProducto() {
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $producto = $pm->productoSucursal->producto;
        $sucursal = $pm->productoSucursal->sucursal;
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $pms = $sucursal->movimientos($producto);
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pms);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pms[0]);
        $this->assertCount(1, $pms);
    }
}
