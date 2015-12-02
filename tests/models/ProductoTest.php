<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversDefaultClass \App\Producto
 */
class ProductoTest extends TestCase {

    use DatabaseTransactions;

    protected $producto;

    /**
     * @coversNothing
     */
    public function testModeloEsValido() {
        $producto = factory(App\Producto::class)->make();
        $this->assertTrue($producto->isValid());
        $this->assertTrue($producto->save());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $producto = factory(App\Producto::class)->create();
        $producto->descripcion_corta = 'MC Hammer';
        $this->assertTrue($producto->isValid('update'));
        $this->assertTrue($producto->save());
    }

    /**
     * @coversNothing
     */
    public function testActivoEsRequerido() {
        $producto = factory(App\Producto::class)->make(['activo' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testActivoEsBooleano() {
        $producto = factory(App\Producto::class)->make(['activo' => 'A']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsRequerido() {
        $producto = factory(App\Producto::class)->make(['clave' => '']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSpiffNoNegativo() {
        $model = factory(App\Producto::class)->make(['spiff' => - 10.00]);
        $this->assertFalse($model->isValid());
        $model->spiff = 10.00;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsUnico() {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make(['clave' => $producto->clave]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveEsMenorDe60Caracteres() {
        $producto = factory(App\Producto::class, 'longclave')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionEsRequerido() {
        $producto = factory(App\Producto::class)->make(['descripcion' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionNoPuedeSerMayorA300Caracteres() {
        $producto = factory(App\Producto::class, 'longdescription')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionCortaNoEsRequerido() {
        $producto = factory(App\Producto::class)->make(['descripcion_corta' => null]);
        $this->assertTrue($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionCortaNoPuedeSerMayorA50Caracteres() {
        $producto = factory(App\Producto::class, 'longshortdesc')->make();
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaEntradaEsActualSiSePoneNull() {
        $producto = factory(App\Producto::class)->make();
        $producto->fecha_entrada = null;
        $this->assertTrue($producto->save());
        $producto = App\Producto::last();
        $this->assertNotNull($producto->fecha_entrada);
    }

    /**
     * @coversNothing
     */
    public function testFechaEntradaEsValido() {
        $producto = factory(App\Producto::class)->make(['fecha_entrada' => 'asdasd']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteEsRequerido() {
        $producto = factory(App\Producto::class)->make(['numero_parte' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteEsUnico() {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make([
            'numero_parte' => $producto->numero_parte
        ]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteEsMaximo30Caracteres(){
        $producto = factory(App\Producto::class, 'longnumpart')->make();
        $this->assertFalse($producto->save());
        $producto->numero_parte = App\Caker::realUnique(App\Producto::class, 'numero_parte', 'regexify', '\w{30}');
        $this->assertTrue($producto->save());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteNoContieneCaracteresInvalidos(){
        $producto = factory(App\Producto::class)->make([
            'numero_parte' => 'Psy12&%_  4581·$5' . rand(0.00,9999.99)
        ]);
        $this->assertFalse($producto->isvalid());
        $producto->numero_parte = 'NP3-4100_F #15/' . rand(0.00,9999.99);
        $this->assertTrue($producto->isvalid());
    }

    /**
     * @coversNothing
     */
    public function testRemateEsRequerido() {
        $producto = factory(App\Producto::class)->make(['remate' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRemateEsBooleano() {
        $producto = factory(App\Producto::class)->make(['remate' => 'A']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSpiffEsRequerido() {
        $producto = factory(App\Producto::class)->make(['spiff' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSpiffEsDecimal() {
        $producto = factory(App\Producto::class)->make(['spiff' => 'string']);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSubclaveEsRequerido() {
        $producto = factory(App\Producto::class)->make(['subclave' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @covers ::boot
     */
    public function testSubclaveTomaElValorDeNumeroDeParteSiDejaVacio() {
        $producto = factory(App\Producto::class)->make(['subclave' => null]);
        $this->assertTrue($producto->save());
        $this->assertSame($producto->numero_parte, $producto->subclave);
    }

    /**
     * @coversNothing
     */
    public function testUpcEsRequerido() {
        $producto = factory(App\Producto::class)->make(['upc' => null]);
        $this->assertFalse($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUpcEsUnico() {
        $producto = factory(App\Producto::class)->create();
        $segundoProducto = factory(App\Producto::class)->make(['upc' => $producto->upc]);
        $this->assertFalse($segundoProducto->isValid());
    }

    /**
     * @covers ::tipoGarantia
     * @group relaciones
     */
    public function testTipoGarantia() {
        $producto = factory(App\Producto::class)->make();
        $tipoGarantia = $producto->tipoGarantia;
        $this->assertInstanceOf(App\TipoGarantia::class, $tipoGarantia);
    }

    /**
     * @covers ::marca
     * @group relaciones
     */
    public function testMarca() {
        $producto = factory(App\Producto::class)->make();
        $marca = $producto->marca;
        $this->assertInstanceOf(App\Marca::class, $marca);
    }

    /**
     * @covers ::margen
     * @group relaciones
     */
    public function testMargen() {
        $producto = factory(App\Producto::class, 'withmargen')->make();
        $margen = $producto->margen;
        $this->assertInstanceOf(App\Margen::class, $margen);
    }

    /**
     * @covers ::unidad
     * @group relaciones
     */
    public function testUnidad() {
        $producto = factory(App\Producto::class)->make();
        $unidad = $producto->unidad;
        $this->assertInstanceOf(App\Unidad::class, $unidad);
    }

    /**
     * @covers ::subfamilia
     * @group relaciones
     */
    public function testSubfamilia() {
        $producto = factory(App\Producto::class)->make();
        $subfamilia = $producto->subfamilia;
        $this->assertInstanceOf(App\Subfamilia::class, $subfamilia);
    }

    /**
     * @covers ::dimension
     * @group relaciones
     */
    public function testDimension() {
        $producto = factory(App\Producto::class)->create();
        factory(App\Dimension::class)->create(['producto_id' => $producto->id]);
        $testDimension = $producto->dimension;
        $this->assertInstanceOf(App\Dimension::class, $testDimension);
    }

    /**
     * @covers ::movimientos
     * @group relaciones
     * @group movimientos
     * @group feature-salidas-unit-errors
     */
    public function testMovimientos() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();

        $productoMovimiento = new App\ProductoMovimiento([
            'movimiento' => 'Test'
        ]);
        $producto->productosSucursales()->where('sucursal_id', $sucursal->id)->first()
            ->movimientos()->save($productoMovimiento);


        $pms = $producto->movimientos()->get();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pms);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pms->first());
    }

    /**
     * @covers ::movimientos
     * @group relaciones
     * @group movimientos
     * @group feature-salidas-unit-errors
     */
    public function testMovimientosConSucursal() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();

        $productoMovimiento = new App\ProductoMovimiento([
            'movimiento' => 'Test'
        ]);
        $producto->productosSucursales()->where('sucursal_id', $sucursal->id)->first()
            ->movimientos()->save($productoMovimiento);

        $pms = $producto->movimientos($sucursal);

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pms);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pms->first());
    }

    /**
     * @covers ::addSucursal
     * @group relaciones
     */
    public function testAddSucursal() {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $this->assertInstanceOf(App\Sucursal::class, $producto->sucursales[0]);
    }

    /**
     * @covers ::sucursales
     * @group relaciones
     */
    public function testSucursales() {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal(factory(App\Sucursal::class)->create());
        $sucursales = $producto->sucursales;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $sucursales);
        $this->assertInstanceOf(App\Sucursal::class, $sucursales[0]);
    }

    /**
     * @covers ::proveedores
     * @group relaciones
     */
    public function testProveedores() {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal(factory(App\Sucursal::class)->create());
        $proveedores = $producto->proveedores();
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $proveedores);
        $this->assertInstanceOf(App\Proveedor::class, $proveedores[0]);
    }

    /**
     * @covers ::productosSucursales
     * @group relaciones
     * @group feature-salidas-unit-errors
     */
    public function testProductosSucursales() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $ps = $producto->productosSucursales;
        $this->assertInstanceOf(App\ProductoSucursal::class, $ps[0]);
    }

    /**
     * @covers ::existencias
     * @group relaciones
     * @group feature-salidas-unit-errors
     */
    public function testExistencias() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $ps = $producto->productosSucursales()->first();
        $existencia = factory(App\Existencia::class)->make();
        $existencia->productoSucursal()->associate($ps)->save();
        $existencias = $producto->existencias;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $existencias);
        $this->assertInstanceOf(App\Existencia::class, $existencias[0]);
    }

    /**
     * @covers ::existencias
     * @group relaciones
     * @group feature-salidas-unit-errors
     */
    public function testExistenciasConSucursal() {
        $sucursal1 = factory(App\Sucursal::class)->create();
        $sucursal2 = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();

        $ps = $producto->productosSucursales[0];
        factory(App\Existencia::class)->make()->productoSucursal()->associate($ps)->save();
        $ps = $producto->productosSucursales[1];
        factory(App\Existencia::class)->make()->productoSucursal()->associate($ps)->save();
        factory(App\Existencia::class)->make()->productoSucursal()->associate($ps)->save();

        $existencia = $producto->existencias($sucursal2);
        $this->assertInstanceOf(App\Existencia::class, $existencia);
    }

    /**
     * @covers ::precios
     * @group relaciones
     * @group precios
     * @group feature-salidas-unit-errors
     */
    public function testPrecios() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();

        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $precios = $producto->precios;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $precios);
        $this->assertInstanceOf(App\Precio::class, $precios[0]);
    }

    /**
     * @covers ::precios
     * @group relaciones
     * @group precios
     */
    public function testPreciosConProveedor() {
        $dico = factory(App\Proveedor::class)->create();
        $pch = factory(App\Proveedor::class)->create();
        $za = factory(App\Sucursal::class, 'noprov')->create(['proveedor_id' => $dico->id]);
        $zz = factory(App\Sucursal::class, 'noprov')->create(['proveedor_id' => $dico->id]);
        $pg = factory(App\Sucursal::class, 'noprov')->create(['proveedor_id' => $pch->id]);
        $pl = factory(App\Sucursal::class, 'noprov')->create(['proveedor_id' => $pch->id]);

        $producto = factory(App\Producto::class)->create();

        $precio = factory(App\Precio::class, 'bare')->make();

        foreach ($producto->productosSucursales as $ps) {
            $ps->precio()->save(clone $precio);
        }

        $precios = App\ProductoSucursal::whereProductoId($producto->id)->get()->count();
        $this->assertCount($precios, $producto->precios);

        $preciosReales = $producto->preciosProveedor();
        $cantidad_proveedores = App\ProductoSucursal::with('sucursal')->whereProductoId($producto->id)->get()->groupBy('sucursal.proveedor_id')->count();

        $this->assertCount($cantidad_proveedores, $preciosReales);
    }

    /**
     * @covers ::entradasDetalles
     * @group relaciones
     * @group feature-salidas-unit-errors
     */
    public function testEntradasDetalles() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create([
            'producto_sucursal_id' => $producto->productosSucursales()->first()->id
        ]);

        $ed = factory(App\EntradaDetalle::class)->create([
            'producto_id' => $producto->id,
            'sucursal_id' => $sucursal->id,
            'entrada_id' => factory(App\Entrada::class, 'full')->create()->id,
            'producto_movimiento_id' => $pm->id
        ]);
        $eds = $producto->entradasDetalles()->get();
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $eds);
        $this->assertInstanceOf(App\EntradaDetalle::class, $eds->first());
    }

    /**
     * @covers ::salidasDetalles
     * @group relaciones
     * @group feature-salidas-unit-errors
     */
    public function testSalidasDetalles() {
        factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal(factory(App\Sucursal::class)->create());
        $pm = factory(App\ProductoMovimiento::class)->create([
            'producto_sucursal_id' => $producto->productosSucursales()->first()->id
        ]);
        factory(App\SalidaDetalle::class)->create([
            'producto_id'            => $producto->id,
            'producto_movimiento_id' => $pm->id,
            'salida_id'              => factory(App\Salida::class, 'full')->create()->id
        ]);
        $sds = $producto->salidasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $sds);
        $this->assertInstanceOf(App\SalidaDetalle::class, $sds[0]);
        $this->assertCount(1, $sds);
    }

    /**
     * @covers ::transferenciasDetalles
     * @group relaciones
     * @group feature-salidas-unit-errors
     */
    public function testTransferenciasDetalles() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();

        $td = factory(App\TransferenciaDetalle::class)->create([
            'producto_id' => $producto->id,
            'transferencia_id' => factory(App\Transferencia::class, 'full')->create()->id,
            'producto_movimiento_id' => factory(App\ProductoMovimiento::class)->create([
                'producto_sucursal_id' => $producto->productosSucursales()->first()->id
            ])->id
        ]);

        $tds = $producto->transferenciasDetalles;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $tds);
        $this->assertInstanceOf(App\TransferenciaDetalle::class, $tds[0]);
        $this->assertCount(1, $tds);
    }

    /**
     * @covers ::apartadosDetalles
     * @group relaciones
     * @group feature-salidas-unit-errors
     */
    public function testApartadosDetalles() {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $pm = factory(App\ProductoMovimiento::class)->create([
            'producto_sucursal_id' => $producto->productosSucursales()->first()->id
        ]);

        factory(App\ApartadoDetalle::class)->create([
            'apartado_id' => factory(App\Apartado::class, 'full')->create()->id,
            'producto_id' => $producto->id,
            'producto_movimiento_id' => $pm->id
        ]);

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $producto->apartadosDetalles()->get());
        $this->assertInstanceOf(App\ApartadoDetalle::class, $producto->apartadosDetalles()->first());
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

    /**
     * @covers ::guardarNuevo
     * @group saves
     */
    public function testGuardarNuevoEsExitoso()
    {
        $unique = "A".time();
        $params = [
            "producto"  => ["activo" => 1, "clave" => $unique, "descripcion" => "jijiji", "descripcion_corta" => "jiji", "fecha_entrada" => "2015-10-01", "numero_parte" => $unique, "remate" => 0, "spiff" => 0.5, "subclave" => "asd", "upc" => $unique],
            "dimension" => ["largo" => 1.0, "ancho" => 2.0, "alto" => 3.0, "peso" => 4.0],
            "precio"    => ["costo" => 2.5, "precio_1" => 90.5, "precio_2" => 90.4, "precio_3" => 90.3, "precio_4" => 90.2, "precio_5" => 90.1, "precio_6" => 90, "precio_7" => 89.09, "precio_8" => 88.00, "precio_9" => 70, "precio_10" => 65.50]
        ];
        factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->make();

        $this->assertTrue($producto->guardarNuevo($params));
    }

    /**
     * @covers ::guardarNuevo
     * @group saves
     */
    public function testGuardarNuevoCreaLaDimension()
    {
        $producto = $this->setUpGuardarNuevoExitoso();

        $this->assertInstanceOf(App\Dimension::class, $producto->dimension);
        $this->assertEquals(4.0, $producto->dimension->peso);
    }

    /**
     * @covers ::guardarNuevo
     * @group saves
     */
    public function testGuardarNuevoCreaElPrecio()
    {
        $producto = $this->setUpGuardarNuevoExitoso();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $producto->precios);
        $this->assertEquals(2.5, $producto->precios()->first()->costo);
    }

    /**
     * @covers ::guardarNuevo
     * @group saves
     */
    public function testGuardarNuevoGuardaParametrosDelModelo()
    {
        $producto = $this->setUpGuardarNuevoExitoso();

        $this->assertEquals('jijiji', $producto->descripcion);
    }

    /**
     * @covers ::actualizar
     * @group saves
     */
    public function testActualizarExitoso()
    {
        $unique = "A".time();
        $params = [
            "producto"  => ["activo" => 1, "clave" => $unique, "descripcion" => "jijiji", "descripcion_corta" => "jiji", "fecha_entrada" => "2015-10-01", "numero_parte" => $unique, "remate" => 0, "spiff" => 0.5, "subclave" => "asd", "upc" => $unique],
            "dimension" => ["largo" => 1.0, "ancho" => 2.0, "alto" => 3.0, "peso" => 4.0],
            "precio"    => ["costo" => 2.5, "precio_1" => 90.5, "precio_2" => 90.4, "precio_3" => 90.3, "precio_4" => 90.2, "precio_5" => 90.1, "precio_6" => 90, "precio_7" => 89.09, "precio_8" => 88.00, "precio_9" => 70, "precio_10" => 65.50]
        ];
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->make();
        $producto->guardarNuevo($params);

        $params = [
            'dimension'   => ['peso' => 2.00],
            'precios'     => [[
                'costo'        => 100.00,
                'proveedor_id' => $sucursal->proveedor_id
            ]],
            'descripcion' => 'TEST_DESCRIPTION',
            'id'          => $producto->id,
            'revisado'    => true
        ];

        $this->assertTrue($producto->actualizar($params));
    }

    /**
     * @covers ::actualizar
     * @group saves
     */
    public function testActualizarPrecioExitoso()
    {
        $producto = $this->setUpActualizarExitoso();
        $sucursal = App\Sucursal::last();
        $productoSucursal = $producto->productosSucursales()->whereSucursalId($sucursal->id)->first();
        $precio = $productoSucursal->precio;

        $this->assertSame(100.00, floatval($precio->costo));
    }

    /**
     * @covers ::actualizar
     * @group saves
     */
    public function testActualizarDimensionExitoso()
    {
        $producto = $this->setUpActualizarExitoso();

        $this->assertSame(2.00, floatval($producto->dimension->peso));
    }

    /**
     * @covers ::actualizar
     * @group saves
     */
    public function testActualizarDetallesExitoso()
    {
        $producto = $this->setUpActualizarExitoso();

        $this->assertSame('TEST_DESCRIPTION', $producto->descripcion);
    }

    /**
     * @covers ::actualizar
     * @group saves
     */
    public function testActualizarEnCasoDeFalloHaceRollback()
    {
        $unique = "A".time();
        $params = [
            "producto"  => ["activo" => 1, "clave" => $unique, "descripcion" => "jijiji", "descripcion_corta" => "jiji", "fecha_entrada" => "2015-10-01", "numero_parte" => $unique, "remate" => 0, "spiff" => 0.5, "subclave" => "asd", "upc" => $unique],
            "dimension" => ["largo" => 1.0, "ancho" => 2.0, "alto" => 3.0, "peso" => 4.0],
            "precio"    => ["costo" => 2.5, "precio_1" => 90.5, "precio_2" => 90.4, "precio_3" => 90.3, "precio_4" => 90.2, "precio_5" => 90.1, "precio_6" => 90, "precio_7" => 89.09, "precio_8" => 88.00, "precio_9" => 70, "precio_10" => 65.50]
        ];
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->make();
        $producto->guardarNuevo($params);

        $params = [
            'dimension'   => ['peso' => 2.00],
            'precios'     => [[
                'costo'        => 'ABC',
                'proveedor_id' => $sucursal->proveedor_id
            ]],
            'descripcion' => 'TEST_DESCRIPTION',
            'id'          => $producto->id,
            'revisado'    => true
        ];

        $this->assertFalse($producto->actualizar($params));
    }

    /**
     * @covers ::actualizar
     * @group saves
     * @group rollbacks
     */
    public function testActualizarIncorrectoHaceRollbackDePrecios()
    {
        $producto = $this->setUpActualizarIncorrecto();
        $precio = $producto->precios()->first();

        $this->assertSame(2.5, floatval($precio->costo));
    }

    /**
     * @covers ::actualizar
     * @group saves
     * @group rollbacks
     */
    public function testActualizarIncorrectoHaceRollbackDeDimension()
    {
        $producto = $this->setUpActualizarIncorrecto();

        $this->assertSame(4.00, floatval($producto->dimension->peso));
    }

    /**
     * @covers ::actualizar
     * @group saves
     * @group rollbacks
     */
    public function testActualizarIncorrectoHaceRollbackDeDetalles()
    {
        $producto = $this->setUpActualizarIncorrecto();

        $this->assertSame('jijiji', $producto->descripcion);
    }

    /**
     * @covers ::pretransferir
     * @group feature-transferencias
     */
    public function testPretransferir()
    {
        $producto = $this->setUpProducto();
        $productoSucursal = $producto->productosSucursales()->first();
        $sucursal = $producto->sucursales()->first();
        $data = $this->setUpPretransferenciaData($productoSucursal, $sucursal);

        $this->assertTrue($producto->pretransferir($data));
    }

    /**
     * @covers ::pretransferir
     * @group feature-transferencias
     */
    public function testPretransferirNoDataFails()
    {
        $producto = $this->setUpProducto();
        $data = null;

        $this->assertFalse($producto->pretransferir($data));
    }

    /**
     * @covers ::pretransferir
     * @group feature-transferencias
     */
    public function testPretransferirDisminuyeCantidadASucursalOrigen()
    {
        $producto = $this->setUpProducto();
        $productoSucursal = $producto->productosSucursales()->first();
        $sucursal = $producto->sucursales()->first();
        $data = $this->setUpPretransferenciaData($productoSucursal, $sucursal);

        $cantidadAntes = $productoSucursal->existencia->cantidad;

        $producto->pretransferir($data);

        $cantidadDespues = $producto->productosSucursales()->first()->existencia->cantidad;

        $this->assertLessThan($cantidadAntes, $cantidadDespues);
    }

    /**
     * @covers ::pretransferir
     * @group feature-transferencias
     */
    public function testPretransferirRestaCantidadExactaASucursalOrigen()
    {
        $producto = $this->setUpProducto();
        $productoSucursal = $producto->productosSucursales()->first();
        $sucursal = $producto->sucursales()->first();
        $data = $this->setUpPretransferenciaData($productoSucursal, $sucursal);

        $producto->pretransferir($data);

        $cantidad = $producto->productosSucursales()->first()->existencia->cantidad;

        $this->assertEquals(70, $cantidad);
    }

    /**
     * @covers ::pretransferir
     * @group feature-transferencias
     */
    public function testPretransferenciaAumentaCantidadPretransferenciaASucursalOrigen()
    {
        $producto = $this->setUpProducto();
        $productoSucursal = $producto->productosSucursales()->first();
        $sucursal = $producto->sucursales()->first();
        $data = $this->setUpPretransferenciaData($productoSucursal, $sucursal);

        $producto->pretransferir($data);

        $cantidad = $producto->productosSucursales()->first()->existencia->cantidad_pretransferencia;

        $this->assertEquals(30, $cantidad);
    }

    /**
     * @covers ::pretransferir
     * @group feature-transferencias
     * @group feature-transferencias-rollback
     */
    public function testPretransferenciaCuandoUnEventoFallaNoCambiaLaCantidadDeSucursalOrigen()
    {
        $producto = $this->setUpProducto();
        $productoSucursal = $producto->productosSucursales()->first();
        $sucursal = $producto->sucursales()->first();
        $data = $this->setUpPretransferenciaBadData($productoSucursal, $sucursal);

        $cantidadAntes = $productoSucursal->existencia->cantidad;

        $producto->pretransferir($data);

        $cantidadDespues = $producto->productosSucursales()->first()->existencia->cantidad;

        $this->assertEquals($cantidadAntes, $cantidadDespues);
    }

    /**
     * @covers ::pretransferir
     * @group feature-transferencias
     * @group feature-transferencias-rollback
     */
    public function testPretransferenciaCuandoUnEventoFallaNoCambiaLaCantidadPretransferenciaDeSucursalOrigen()
    {
        $producto = $this->setUpProducto();
        $productoSucursal = $producto->productosSucursales()->first();
        $sucursal = $producto->sucursales()->first();
        $data = $this->setUpPretransferenciaBadData($productoSucursal, $sucursal);

        $producto->pretransferir($data);

        $cantidad = $producto->productosSucursales()->first()->existencia->cantidad_pretransferencia;

        $this->assertEquals(0, $cantidad);
    }

    private function setUpGuardarNuevoExitoso()
    {
        $unique = "A".time();
        $params = [
            "producto"  => ["activo" => 1, "clave" => $unique, "descripcion" => "jijiji", "descripcion_corta" => "jiji", "fecha_entrada" => "2015-10-01", "numero_parte" => $unique, "remate" => 0, "spiff" => 0.5, "subclave" => "asd", "upc" => $unique],
            "dimension" => ["largo" => 1.0, "ancho" => 2.0, "alto" => 3.0, "peso" => 4.0],
            "precio"    => ["costo" => 2.5, "precio_1" => 90.5, "precio_2" => 90.4, "precio_3" => 90.3, "precio_4" => 90.2, "precio_5" => 90.1, "precio_6" => 90, "precio_7" => 89.09, "precio_8" => 88.00, "precio_9" => 70, "precio_10" => 65.50]
        ];
        factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->make();

        $producto->guardarNuevo($params);

        return $producto;
    }

    private function setUpActualizarExitoso()
    {
        $unique = "A".time();
        $params = [
            "producto"  => ["activo" => 1, "clave" => $unique, "descripcion" => "jijiji", "descripcion_corta" => "jiji", "fecha_entrada" => "2015-10-01", "numero_parte" => $unique, "remate" => 0, "spiff" => 0.5, "subclave" => "asd", "upc" => $unique],
            "dimension" => ["largo" => 1.0, "ancho" => 2.0, "alto" => 3.0, "peso" => 4.0],
            "precio"    => ["costo" => 2.5, "precio_1" => 90.5, "precio_2" => 90.4, "precio_3" => 90.3, "precio_4" => 90.2, "precio_5" => 90.1, "precio_6" => 90, "precio_7" => 89.09, "precio_8" => 88.00, "precio_9" => 70, "precio_10" => 65.50]
        ];
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->make();
        $producto->guardarNuevo($params);

        $params = [
            'dimension'   => ['peso' => 2.00],
            'precios'     => [[
                'costo'        => 100.00,
                'proveedor_id' => $sucursal->proveedor_id
            ]],
            'descripcion' => 'TEST_DESCRIPTION',
            'id'          => $producto->id,
            'revisado'    => true
        ];

        $producto->actualizar($params);
        return App\Producto::find($producto->id);
    }

    private function setUpActualizarIncorrecto()
    {
        $unique = "A".time();
        $params = [
            "producto"  => ["activo" => 1, "clave" => $unique, "descripcion" => "jijiji", "descripcion_corta" => "jiji", "fecha_entrada" => "2015-10-01", "numero_parte" => $unique, "remate" => 0, "spiff" => 0.5, "subclave" => "asd", "upc" => $unique],
            "dimension" => ["largo" => 1.0, "ancho" => 2.0, "alto" => 3.0, "peso" => 4.0],
            "precio"    => ["costo" => 2.5, "precio_1" => 90.5, "precio_2" => 90.4, "precio_3" => 90.3, "precio_4" => 90.2, "precio_5" => 90.1, "precio_6" => 90, "precio_7" => 89.09, "precio_8" => 88.00, "precio_9" => 70, "precio_10" => 65.50]
        ];
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->make();
        $producto->guardarNuevo($params);

        $params = [
            'dimension'   => ['peso' => 2.00],
            'precios'     => [[
                'costo'        => 'ABC',
                'proveedor_id' => $sucursal->proveedor_id
            ]],
            'descripcion' => 'TEST_DESCRIPTION',
            'id'          => $producto->id,
            'revisado'    => true
        ];
        $producto->actualizar($params);
        return App\Producto::find($producto->id);
    }

    private function setUpPretransferenciaData($productoSucursal, $sucursal)
    {
        return [
            ['id' => $productoSucursal->id, 'cantidad' => 100, 'pretransferencia'  => 0],
            ['id' => ($productoSucursal->id + 1), 'cantidad' => 100, 'pretransferencia'  => 10],
            ['id' => ($productoSucursal->id + 2), 'cantidad' => 100, 'pretransferencia'  => 10],
            ['id' => ($productoSucursal->id + 3), 'cantidad' => 100, 'pretransferencia'  => 10],
            ['sucursal_origen' => $sucursal->id],
        ];
    }

    private function setUpPretransferenciaDataToSelf($productoSucursal, $sucursal)
    {
        return [
            ['id' => $productoSucursal->id, 'cantidad' => 100, 'pretransferencia'  => 1],
            ['id' => ($productoSucursal->id + 1), 'cantidad' => 100, 'pretransferencia'  => 10],
            ['id' => ($productoSucursal->id + 2), 'cantidad' => 100, 'pretransferencia'  => 10],
            ['id' => ($productoSucursal->id + 3), 'cantidad' => 100, 'pretransferencia'  => 10],
            ['sucursal_origen' => $sucursal->id],
        ];
    }

    private function setUpPretransferenciaBadData($productoSucursal, $sucursal)
    {
        return [
            ['id' => $productoSucursal->id, 'cantidad' => 100, 'pretransferencia'  => 0],
            ['id' => ($productoSucursal->id + 1), 'cantidad' => 100, 'pretransferencia'  => 10],
            ['id' => ($productoSucursal->id + 2), 'cantidad' => 100, 'pretransferencia'  => 10],
            ['id' => ($productoSucursal->id + 3), 'cantidad' => 100, 'pretransferencia'  => 'c'],
            ['sucursal_origen' => $sucursal->id],
        ];
    }

    private function setUpProducto()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        factory(App\Sucursal::class)->create();
        factory(App\Sucursal::class)->create();
        factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();

        $productoSucursal = $producto->productosSucursales()->first();
        $productoSucursal->existencia->update([
            'cantidad' => 100
        ]);
        return $producto;
    }
}
