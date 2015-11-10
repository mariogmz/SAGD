<?php

/**
 * @coversDefaultClass \App\Producto
 */
class ProductoTest extends TestCase {

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
    public function testNumeroDeParteMaximo30Caracteres(){
        $producto = factory(App\Producto::class,'longnumpart')->make();
        $this->assertFalse($producto->isValid());
        $producto->numero_parte = 'HelloWorld';
        $this->assertTrue($producto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNumeroDeParteNoContieneEspaciosEnBlanco(){
        $producto = factory(App\Producto::class)->make(
            ['numero_parte' => ' Esp_ac1ios en b1la-nco ']
        );
        $this->assertFalse($producto->isValid());
        $producto->numero_parte = preg_replace('/\s+/','', $producto->numero_parte);
        $this->assertTrue($producto->isValid());
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
     */
    public function testMovimientos() {
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $producto = $pm->productoSucursal->producto;
        $pms = $producto->movimientos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pms);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pms[0]);
    }

    /**
     * @covers ::movimientos
     * @group relaciones
     * @group movimientos
     */
    public function testMovimientosConSucursal() {
        $pm = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
        $producto = $pm->productoSucursal->producto;
        $sucursal = $pm->productoSucursal->sucursal;
        $producto->addSucursal(factory(App\Sucursal::class)->create());
        $pms = $producto->movimientos($sucursal);
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pms);
        $this->assertInstanceOf(App\ProductoMovimiento::class, $pms[0]);
        $this->assertCount(1, $pms);
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
     */
    public function testProductosSucursales() {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal(factory(App\Sucursal::class)->create());
        $ps = $producto->productosSucursales;
        $this->assertInstanceOf(App\ProductoSucursal::class, $ps[0]);
    }

    /**
     * @covers ::existencias
     * @group relaciones
     */
    public function testExistencias() {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal(factory(App\Sucursal::class)->create());
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
    public function testExistenciasConSucursal() {
        $producto = factory(App\Producto::class)->create();
        $sucursal1 = factory(App\Sucursal::class)->create();
        $sucursal2 = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal1);
        $producto->addSucursal($sucursal2);

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
     */
    public function testPrecios() {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
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
        $producto = factory(App\Producto::class)->create();
        $dico = factory(App\Proveedor::class)->create();
        $pch = factory(App\Proveedor::class)->create();
        $za = factory(App\Sucursal::class, 'noprov')->create(['proveedor_id' => $dico->id]);
        $zz = factory(App\Sucursal::class, 'noprov')->create(['proveedor_id' => $dico->id]);
        $pg = factory(App\Sucursal::class, 'noprov')->create(['proveedor_id' => $pch->id]);
        $pl = factory(App\Sucursal::class, 'noprov')->create(['proveedor_id' => $pch->id]);

        $producto->addSucursal($za);
        $producto->addSucursal($zz);
        $producto->addSucursal($pg);
        $producto->addSucursal($pl);

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
     */
    public function testEntradasDetalles() {
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
    public function testSalidasDetalles() {
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
     */
    public function testTransferenciasDetalles() {
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
    public function testApartadosDetalles() {
        $producto = factory(App\Producto::class)->create();
        factory(App\ApartadoDetalle::class, 'full')->create(['producto_id' => $producto->id]);
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

    /**
     * @covers ::guardarNuevo
     * @group saves
     */
    public function testSaveWithData() {
        $params = [
            "producto"  => ["activo" => 1, "clave" => "ALIBABA", "descripcion" => "jijiji", "descripcion_corta" => "jiji", "fecha_entrada" => "2015-10-01", "numero_parte" => "jiji", "remate" => 0, "spiff" => 0.5, "subclave" => "asd", "upc" => 2, "tipo_garantia_id" => 1, "marca_id" => 1, "margen_id" => 1, "unidad_id" => 1, "subfamilia" => 1],
            "dimension" => ["largo" => 1.0, "ancho" => 2.0, "alto" => 3.0, "peso" => 4.0],
            "precio"    => ["costo" => 2.5, "precio_1" => 90.5, "precio_2" => 90.4, "precio_3" => 90.3, "precio_4" => 90.2, "precio_5" => 90.1, "precio_6" => 90, "precio_7" => 89.09, "precio_8" => 88.00, "precio_9" => 70, "precio_10" => 65.50]
        ];
        $producto = factory(App\Producto::class)->make();
        factory(App\Sucursal::class)->make();

        $this->assertTrue($producto->guardarNuevo($params));

        // Dimension
        $this->assertNotNull($producto->dimension);
        $this->assertInstanceOf(App\Dimension::class, $producto->dimension);
        // ProductoSucursal
        $this->assertGreaterThan(0, count($producto->productosSucursales));
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $producto->productosSucursales);

        $this->assertNotNull($producto->precios);
        $this->assertNotNull($producto->preciosProveedor());

        $this->assertNotNull($producto->existencias);
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $producto->existencias);
        $this->assertGreaterThan(0, count($producto->existencias));
    }

    /**
     * @covers ::actualizar
     * @group saves
     */
    public function testUpdateExitoso() {

        $producto = factory(App\Producto::class)->create();
        $producto->dimension()->save(new App\Dimension([
            'largo' => 1,
            'ancho' => 1,
            'alto'  => 1,
            'peso'  => 1
        ]));
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);

        $precio = factory(App\Precio::class)->make();
        $precio->producto_sucursal_id = $producto->productosSucursales()->first()->id;
        $this->assertTrue($precio->save());

        $params = [
            'dimension'   => [
                'peso' => 2.00
            ],
            'precios'     => [
                [
                    'costo'        => 100.00,
                    'proveedor_id' => $sucursal->proveedor_id
                ]
            ],
            'id'          => $producto->id,
            'descripcion' => 'TEST_DESCRIPTION',
            'revisado'    => true
        ];

        $this->assertTrue($producto->actualizar($params));

        $producto = App\Producto::find($producto->id);
        $this->assertSame($params['descripcion'], $producto->descripcion);
        $this->assertSame($params['dimension']['peso'], floatval($producto->dimension->peso));

        foreach (App\ProductoSucursal::whereProductoId($producto->id)->whereSucursalId($sucursal->id)->get() as $producto_sucursal) {
            $precio = $producto_sucursal->precio;
            $this->assertSame($params['precios'][0]['costo'], floatval($precio->costo));
        }

    }

    /**
     * @covers ::actualizar
     * @group saves
     */
    public function testUpdateEnCasoDeFalloHaceRollback() {

        $producto = factory(App\Producto::class)->create();
        $producto->dimension()->save(new App\Dimension([
            'largo' => 1,
            'ancho' => 1,
            'alto'  => 1,
            'peso'  => 1
        ]));
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);

        $precio = factory(App\Precio::class)->make();
        $precio->producto_sucursal_id = $producto->productosSucursales()->first()->id;
        $this->assertTrue($precio->save());

        $params = [
            'dimension'   => [
                'peso' => 2.00
            ],
            'precios'     => [
                [
                    'costo'        => 'ABC',
                    'proveedor_id' => $sucursal->proveedor_id
                ]
            ],
            'id'          => $producto->id,
            'descripcion' => 'TEST_DESCRIPTION',
            'revisado'    => false
        ];

        $this->assertFalse($producto->actualizar($params));

        $producto = App\Producto::find($producto->id);
        $this->assertNotSame($params['descripcion'], $producto->descripcion);
        $this->assertNotSame($params['dimension']['peso'], floatval($producto->dimension->peso));

        foreach (App\ProductoSucursal::whereProductoId($producto->id)->whereSucursalId($sucursal->id)->get() as $producto_sucursal) {
            $precio = $producto_sucursal->precio;
            $this->assertNotSame($params['precios'][0]['costo'], floatval($precio->costo));
        }
    }
}
