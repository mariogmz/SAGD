<?php

/**
 * @coversDefaultClass \App\EntradaDetalle
 */
class EntradaDetalleTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $ed = factory(App\EntradaDetalle::class)->make();
        $this->assertTrue($ed->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->create();
        $ed->costo = 1991.0;
        $ed->importe = $ed->costo * $ed->cantidad;
        $this->assertTrue($ed->isValid('update'));
        $this->assertTrue($ed->save());
        $this->assertSame(1991.0, $ed->costo);
    }

    /**
     * @coversNothing
     */
    public function testCostoEsObligatorio()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['costo' => null]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoTieneQueSerPositivo()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['costo' => -1.0]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoTieneQueSerDecimal()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['costo' => 'a']);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsObligatorio()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['cantidad' => null]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsPositivo()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['cantidad' => -1]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCantidadEsEntero()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['cantidad' => 'a']);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testImporteEsObligatorio()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['importe' => null]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testImporteEsPositivo()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['importe' => -1.0]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testImporteEsDecimal()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['importe' => 'a']);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @coversNothing
     */
    public function testImporteEsCostoPorCantidad()
    {
        $ed = factory(App\EntradaDetalle::class)->make(['importe' => 1.0]);
        $this->assertFalse($ed->isValid());
    }

    /**
     * @covers ::entrada
     * @group relaciones
     */
    public function testEntrada()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->make();
        $entrada = $ed->entrada;
        $this->assertInstanceOf(App\Entrada::class, $entrada);
    }

    /**
     * @covers ::entrada
     * @group relaciones
     */
    public function testEntradaAssociate()
    {
        $ed = factory(App\EntradaDetalle::class, 'noentrada')->make();
        $entrada = factory(App\Entrada::class, 'full')->create();
        $ed->entrada()->associate($entrada);
        $ed->save();
        $this->assertInstanceOf(App\Entrada::class, $ed->entrada);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->make();
        $producto = $ed->producto;
        $this->assertInstanceOf(App\Producto::class, $producto);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProductoAssociate()
    {
        $ed = factory(App\EntradaDetalle::class, 'noproducto')->make();
        $producto = factory(App\Producto::class)->create();
        $ed->producto()->associate($producto);
        $ed->save();
        $this->assertInstanceOf(App\Producto::class, $ed->producto);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->make();
        $sucursal = $ed->sucursal;
        $this->assertInstanceOf(App\Sucursal::class, $sucursal);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursalAssociate()
    {
        $ed = factory(App\EntradaDetalle::class, 'nosucursal')->make();
        $sucursal = factory(App\Sucursal::class)->create();
        $ed->sucursal()->associate($sucursal);
        $ed->save();
        $this->assertInstanceOf(App\Sucursal::class, $ed->sucursal);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimiento()
    {
        $ed = factory(App\EntradaDetalle::class, 'full')->make();
        $pm = $ed->productoMovimiento;
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pm);
    }

    /**
     * @covers ::productoMovimiento
     * @group relaciones
     */
    public function testProductoMovimientoAssociate()
    {
        $ed = factory(App\EntradaDetalle::class, 'noproductomovimiento')->make();
        $producto = $ed->producto;
        $pm = factory(App\ProductoMovimiento::class, 'withproduct')->create(['producto_id' => $producto->id]);
        $ed->productoMovimiento()->associate($pm);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $ed->productoMovimiento);
    }
}
