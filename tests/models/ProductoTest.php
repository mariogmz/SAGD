<?php

/**
 * @coversDefaultClass \App\Producto
 */
class ProductoTest extends TestCase
{
    protected $producto;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $producto = factory(App\Producto::class)->make();
        $this->assertTrue($producto->isValid());
        $this->assertTrue($producto->save());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->descripcion_corta = 'MC Hammer';
        $this->assertTrue($producto->isValid('update'));
        $this->assertTrue($producto->save());
    }

    /**
     * @coversNothing
     */
    public function testActivoEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['activo' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testActivoEsBooleano()
    {
        $producto = factory(App\Producto::class)->make(['activo' => 'A']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['clave' => '']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnico()
    {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make(['clave' => $producto->clave]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsMenorDe60Caracteres()
    {
        $producto = factory(App\Producto::class, 'longclave')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['descripcion' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoPuedeSerMayorA300Caracteres()
    {
        $producto = factory(App\Producto::class, 'longdescription')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionCortaNoEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['descripcion_corta' => null]);
        $this->assertTrue($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionCortaNoPuedeSerMayorA50Caracteres()
    {
        $producto = factory(App\Producto::class, 'longshortdesc')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaEntradaEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['fecha_entrada' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaEntradaEsValido()
    {
        $producto = factory(App\Producto::class)->make(['fecha_entrada' => 'asdasd']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['numero_parte' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteEsUnico()
    {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make([
            'numero_parte' => $producto->numero_parte
        ]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRemateEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['remate' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRemateEsBooleano()
    {
        $producto = factory(App\Producto::class)->make(['remate' => 'A']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSpiffEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['spiff' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSpiffEsDecimal()
    {
        $producto = factory(App\Producto::class)->make(['spiff' => 'string']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSubclaveEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['subclave' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers ::boot
     */
    public function testSubclaveSiesVacioTomaValorDeNumeroDeParte()
    {
        $producto = factory(App\Producto::class)->make(['subclave' => null]);
        $this->assertTrue($producto->save());
        $this->assertSame($producto->numero_parte, $producto->subclave);
    }

    /**
     * @coversNothing
     */
    public function testUpcEsRequerido()
    {
        $producto = factory(App\Producto::class)->make(['upc' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUpcEsUnico()
    {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make(['upc' => $producto->upc]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @covers ::tipoGarantia
     * @group relaciones
     */
    public function testTipoGarantia()
    {
        $producto = factory(App\Producto::class)->make();
        $tipoGarantia = $producto->tipoGarantia;
        $this->assertInstanceOf(App\TipoGarantia::class, $tipoGarantia);
    }

    /**
     * @covers ::marca
     * @group relaciones
     */
    public function testMarca()
    {
        $producto = factory(App\Producto::class)->make();
        $marca = $producto->marca;
        $this->assertInstanceOf(App\Marca::class, $marca);
    }

    /**
     * @covers ::margen
     * @group relaciones
     */
    public function testMargen()
    {
        $producto = factory(App\Producto::class, 'withmargen')->make();
        $margen = $producto->margen;
        $this->assertInstanceOf(App\Margen::class, $margen);
    }

    /**
     * @covers ::unidad
     * @group relaciones
     */
    public function testUnidad()
    {
        $producto = factory(App\Producto::class)->make();
        $unidad = $producto->unidad;
        $this->assertInstanceOf(App\Unidad::class, $unidad);
    }

    /**
     * @covers ::subfamilia
     * @group relaciones
     */
    public function testSubfamilia()
    {
        $producto = factory(App\Producto::class)->make();
        $subfamilia = $producto->subfamilia;
        $this->assertInstanceOf(App\Subfamilia::class, $subfamilia);
    }

    /**
     * @covers ::dimension
     * @group relaciones
     */
    public function testDimension()
    {
        $producto = factory(App\Producto::class)->create();
        $dimension = factory(App\Dimension::class)->create(['producto_id' => $producto->id]);
        $testDimension = $producto->dimension;
        $this->assertInstanceOf(App\Dimension::class, $testDimension);
    }

    /**
     * @covers ::productoMovimientos
     * @group relaciones
     */
    public function testProductoMovimientos()
    {
        $producto = factory(App\Producto::class)->create();
        factory(App\ProductoMovimiento::class, 'withproduct')->create([
            'producto_id' => $producto->id
        ]);
        $pms = $producto->productoMovimientos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pms);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pms[0]);
    }

    /**
     * @covers ::addSucursal
     * @group relaciones
     */
    public function testAddSucursal()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $this->assertInstanceOf(App\Sucursal::class, $producto->sucursales[0]);
    }

    /**
     * @covers ::addProveedor
     * @group relaciones
     */
    public function testAddProveedor()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        factory(App\Sucursal::class)->create(['proveedor_id' => $sucursal->proveedor->id]);
        $producto->addProveedor($sucursal->proveedor);
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $producto->proveedores);
        $this->assertInstanceOf(App\Proveedor::class, $producto->proveedores[0]);
    }

    /**
     * @covers ::sucursales
     * @group relaciones
     */
    public function testSucursales()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $sucursales = $producto->sucursales;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $sucursales);
        $this->assertInstanceOf(App\Sucursal::class, $sucursales[0]);
    }

    /**
     * @covers ::proveedores
     * @group relaciones
     */
    public function testProveedores()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $proveedores = $producto->proveedores;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $proveedores);
        $this->assertInstanceOf(App\Proveedor::class, $proveedores[0]);
    }

    /**
     * @covers ::productosSucursales
     * @group relaciones
     */
    public function testProductosSucursales()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $ps = $producto->productosSucursales;
        $this->assertInstanceOf(App\ProductoSucursal::class, $ps[0]);
    }

    /**
     * @covers ::existencias
     * @group relaciones
     */
    public function testExistencias()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $ps = $producto->productosSucursales[0];
        $existencia = factory(App\Existencia::class)->make();
        $existencia->productoSucursal()->associate($ps)->save();
        $existencias = $producto->existencias;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $existencias);
        $this->assertInstanceOf(App\Existencia::class, $existencias[0]);
    }

    /**
     * @covers ::existencias
     * @group relaciones
     */
    public function testExistenciasConSucursal()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal1 = factory(App\Sucursal::class)->create();
        $sucursal2 = factory(App\Sucursal::class)->create();
        $producto->addSucursal( $sucursal1 );
        $producto->addSucursal( $sucursal2 );

        $ps = $producto->productosSucursales[0];
        factory(App\Existencia::class)->make()->productoSucursal()->associate($ps)->save();
        $ps = $producto->productosSucursales[1];
        factory(App\Existencia::class)->make()->productoSucursal()->associate($ps)->save();
        factory(App\Existencia::class)->make()->productoSucursal()->associate($ps)->save();

        $existencias = $producto->existencias($sucursal2->id);

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $existencias);
        $this->assertInstanceOf(App\Existencia::class, $existencias[0]);
    }

    /**
     * @covers ::precios
     * @group relaciones
     */
    public function testPrecios()
    {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addProveedor( $sucursal->proveedor );
        $ps = $producto->productosSucursales[0];
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $precios = $producto->precios;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $precios);
        $this->assertInstanceOf(App\Precio::class, $precios[0]);
    }

    /**
     * @covers ::precios
     * @group relaciones
     */
    public function testPreciosConProveedor()
    {
        $producto = factory(App\Producto::class)->create();
        $proveedor1 = factory(App\Sucursal::class)->create()->proveedor;
        $proveedor2 = factory(App\Sucursal::class)->create()->proveedor;
        $producto->addProveedor($proveedor1);
        $producto->addProveedor($proveedor2);

        $ps1 = $producto->productosSucursales->first();
        $ps2 = $producto->productosSucursales->last();
        $precio1 = factory(App\Precio::class)->make();
        $precio2 = factory(App\Precio::class)->make();
        $precio1->productoSucursal()->associate($ps1)->save();
        $precio2->productoSucursal()->associate($ps2)->save();

        $precios = $producto->precios($proveedor1->id);
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $precios);
        $this->assertInstanceOf(App\Precio::class, $precios[0]);
    }

    /**
     * @covers ::entradasDetalles
     * @group relaciones
     */
    public function testEntradasDetalles()
    {
        $producto = factory(App\Producto::class)->create();
        $ed = factory(App\EntradaDetalle::class, 'full')->create(['producto_id' => $producto->id]);
        $eds = $producto->entradasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $eds);
        $this->assertInstanceOf(App\EntradaDetalle::class, $eds[0]);
        $this->assertCount(1, $eds);
    }

    /**
     * @covers ::salidasDetalles
     * @group relaciones
     */
    public function testSalidasDetalles()
    {
        $producto = factory(App\Producto::class)->create();
        $sd = factory(App\SalidaDetalle::class, 'full')->create(['producto_id' => $producto->id]);
        $sds = $producto->salidasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $sds);
        $this->assertInstanceOf(App\SalidaDetalle::class, $sds[0]);
        $this->assertCount(1, $sds);
    }

    /**
     * @covers ::transferenciasDetalles
     * @group relaciones
     */
    public function testTransferenciasDetalles()
    {
        $producto = factory(App\Producto::class)->create();
        $td = factory(App\TransferenciaDetalle::class, 'full')->create([
            'producto_id' => $producto->id]);
        $tds = $producto->transferenciasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $tds);
        $this->assertInstanceOf(App\TransferenciaDetalle::class, $tds[0]);
        $this->assertCount(1, $tds);
    }

    /**
     * @covers ::apartadosDetalles
     * @group relaciones
     */
    public function testApartadosDetalles()
    {
        $producto = factory(App\Producto::class)->create();
        $ad = factory(App\ApartadoDetalle::class, 'full')->create(['producto_id' => $producto->id]);
        $ads = $producto->apartadosDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $ads);
        $this->assertInstanceOf(App\ApartadoDetalle::class, $ads[0]);
        $this->assertCount(1, $ads);
    }

    /**
     * @covers ::reposiciones
     * @group relaciones
     */
    public function testReposiciones() {
        $parent = factory(App\Producto::class)->create();
        factory(App\Reposicion::class)->create([
            'producto_id' => $parent->id
        ]);
        $children = $parent->reposiciones;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Reposicion', $children[0]);
        $this->assertCount(1, $children);
    }
}
