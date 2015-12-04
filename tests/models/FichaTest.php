<?php

/**
 * @coversDefaultClass \App\Ficha
 */
class FichaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testProductoIdRequerido() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->producto_id);
        $this->assertFalse($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProductoIdEntero() {
        $ficha = factory(App\Ficha::class)->make();
        $producto_id = $ficha->producto_id;
        $ficha->producto_id = 'texto';
        $this->assertFalse($ficha->isValid());
        $ficha->producto_id = $producto_id;
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProductoIdUnico() {
        $ficha1 = factory(App\Ficha::class)->create();
        $ficha2 = factory(App\Ficha::class)->make([
            'producto_id' => $ficha1->producto_id
        ]);
        $this->assertFalse($ficha2->isValid());
        $this->assertFalse($ficha2->save());
    }

    /**
     * @coversNothing
     */
    public function testModeloEsActualizable() {
        $ficha = factory(App\Ficha::class)->create();
        $ficha->titulo = 'Titulo';
        $this->assertTrue($ficha->save());
    }

    /**
     * @coversNothing
     */
    public function testCalidadEsOpcional() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->calidad);
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTituloEsRequerido() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->titulo);
        $this->assertFalse($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTituloEsMaximo50Caracteres() {
        $ficha = factory(App\Ficha::class, 'titulolargo')->make();
        $this->assertFalse($ficha->isValid());
        $ficha->titulo = 'TITULO';
        $this->assertTrue($ficha->isValid());
    }


    /**
     * @coversNothing
     */
    public function testRevisadaEsBooleano() {
        $ficha = factory(App\Ficha::class)->make([
            'revisada' => 'revisada'
        ]);
        $this->assertFalse($ficha->isValid());
        $ficha->revisada = 1;
        $this->assertTrue($ficha->isValid());
        $ficha->revisada = false;
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRevisadaEsOpcional() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->revisada);
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @coversNothing
     */
    public function testRevisadaEsPorDefaultFalso() {
        $ficha = factory(App\Ficha::class)->make();
        unset($ficha->revisada);
        $this->assertTrue($ficha->save());
        $ficha = $ficha->fresh();
        $this->assertFalse(boolval($ficha->revisada));
    }

    /**
     * @coversNothing
     */
    public function testCalidadDebeSerUnValorDeLaLista() {
        $ficha = factory(App\Ficha::class)->make([
            'calidad' => 'OTRO'
        ]);
        $this->assertFalse($ficha->isValid());
        $ficha->calidad = 'INTERNO';
        $this->assertTrue($ficha->isValid());
        $ficha->calidad = 'FABRICANTE';
        $this->assertTrue($ficha->isValid());
        $ficha->calidad = 'ICECAT';
        $this->assertTrue($ficha->isValid());
        $ficha->calidad = 'NOEDITOR';
        $this->assertTrue($ficha->isValid());
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto() {
        $producto = factory(App\Producto::class)->create();
        $ficha = factory(App\Ficha::class)->create([
            'producto_id' => $producto->id
        ]);
        $result = $ficha->producto;
        $this->assertInstanceOf('App\Producto', $result);
        $this->assertEquals($producto->id, $result->id);
    }

    /**
     * @covers ::caracteristicas
     * @group relaciones
     */
    public function testCaracteristicas() {
        $ficha = factory(App\Ficha::class)->create();
        factory(App\FichaCaracteristica::class, 5)->create([
            'ficha_id' => $ficha->id
        ]);
        $results = $ficha->caracteristicas;
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $results);
        $this->assertInstanceOf('App\FichaCaracteristica', $results->first());
        $this->assertSame($ficha->id, $results->first()->ficha_id);
    }

    /**
     * @covers ::obtenerFichaDesdeIcecat
     * @group icecat
     * @uses \App\Producto
     * @uses \App\FichaCaracteristica
     * @uses \Sagd\IcecatFeed
     */
    public function testObtenerFichaDesdeIcecatFichaEncontrada() {

        $producto = $this->setUpFichaData();

        $ficha = new App\Ficha();
        $ficha->producto()->associate($producto);
        $this->assertNotFalse($ficha->obtenerFichaDesdeIcecat());

        $caracteristicas = $ficha->caracteristicas;

        // Revisar ficha
        $this->assertGreaterThanOrEqual(1, $caracteristicas->count());
        $this->assertSame('ICECAT', $ficha->calidad);
        $this->assertSame('HP Officejet 6000 Wireless Printer - E609n', $ficha->titulo);
        $this->assertFalse(boolval($ficha->revisada));

        // Revisar características
        $this->assertLessThanOrEqual(28, $caracteristicas->count());

        foreach ($caracteristicas as $caracteristica) {
            $this->assertNotEmpty($caracteristica->valor);
            $this->assertNotEmpty($caracteristica->valor_presentacion);
        }
    }

    /**
     * @covers ::obtenerFichaDesdeIcecat
     * @group icecat
     * @uses \App\Producto
     * @uses \App\FichaCaracteristica
     * @uses \Sagd\IcecatFeed
     */
    public function testObtenerFichaDesdeIcecatFichaEncontradaSobreescribirDatos() {

        $producto = $this->setUpFichaData();

        $ficha = new App\Ficha();
        $ficha->producto()->associate($producto);
        $this->assertNotFalse($ficha->obtenerFichaDesdeIcecat(true));

        $caracteristicas = $ficha->caracteristicas;

        // Revisar ficha
        $this->assertGreaterThanOrEqual(1, $caracteristicas->count());
        $this->assertSame('ICECAT', $ficha->calidad);
        $this->assertSame('HP Officejet 6000 Wireless Printer - E609n', $ficha->titulo);
        $this->assertFalse(boolval($ficha->revisada));

        // Revisar características
        $this->assertLessThanOrEqual(28, $caracteristicas->count());

        foreach ($caracteristicas as $caracteristica) {
            $this->assertNotEmpty($caracteristica->valor);
            $this->assertNotEmpty($caracteristica->valor_presentacion);
        }
        $producto = $producto->fresh();
        $this->assertSame(substr('HP Officejet 6000 Wireless Printer - E609n, Officejet. Velocidad de impresión (color, calidad de bosquejo, A4/US Carta): 31 ppm, Velocidad de impresión (color, calidad normal, A4/US Carta): 10 ppm. Memoria interna: 32 MB. Peso: 5,5 kg. Consumo de energía (apagado): 0,4 W. Cantidad por palé: 50 pieza(s)',0,299), $producto->descripcion);
        $this->assertSame(substr("HP Officejet Officejet 6000 Wireless Printer - E609n, 5 - 40 °C, -40 - 60 °C, 20 - 90%",0,49), $producto->descripcion_corta);
    }

    /**
     * @covers ::obtenerFichaDesdeIcecat
     * @group icecat
     * @uses \App\Producto
     * @uses \App\FichaCaracteristica
     * @uses \Sagd\IcecatFeed
     */
    public function testObtenerFichaDesdeIcecatFichaNoEncontrada() {
        $icecat_supplier = App\IcecatSupplier::firstOrNew([
            'name' => 'hp',
        ]);
        $icecat_supplier->marca->update([
            'nombre' => 'hp'
        ]);
        $producto = factory(App\Producto::class)->create([
            'marca_id'     => $icecat_supplier->marca->id,
            'numero_parte' => 'CB049AT'
        ]);
        if (empty($producto)) {
            $producto = App\Producto::whereNumeroParte('CB049AT')->first();
            $producto->marca()->associate($icecat_supplier->marca);
        }

        $ficha = new App\Ficha();
        $ficha->producto()->associate($producto);

        $this->assertFalse($ficha->obtenerFichaDesdeIcecat());
        $caracteristicas = $ficha->caracteristicas;

        // Revisar ficha
        $this->assertGreaterThanOrEqual(0, $caracteristicas->count());
        $this->assertSame('INTERNO', $ficha->calidad);
        $this->assertEmpty($ficha->titulo);
        $this->assertFalse(boolval($ficha->revisada));

        // Revisar Producto

    }

    private function setUpFichaData() {
        factory(App\Marca::class)->create([
            'nombre' => 'hp',
            'clave'  => 'HP'
        ]);
        $marca = App\Marca::whereNombre('hp')->first();
        factory(App\IcecatSupplier::class)->create([
            'name'     => 'hp',
            'marca_id' => $marca->id
        ]);
        factory(App\IcecatCategory::class)->create([
            'icecat_id' => 234
        ]);
        factory(App\IcecatFeature::class)->create([
            'icecat_id' => 460
        ]);
        factory(App\IcecatCategoryFeatureGroup::class)->create([
            'icecat_id' => 46
        ]);
        factory(App\IcecatCategoryFeature::class)->create([
            'icecat_category_id'               => 234,
            'icecat_feature_id'                => 460,
            'icecat_category_feature_group_id' => 46
        ]);

        $producto = App\Producto::whereNumeroParte('CB049A')->first();
        if ($producto) {
            $producto->update([
                'numero_parte' => rand(1, 999999999)
            ]);
        }

        return factory(App\Producto::class)->create([
            'numero_parte' => 'CB049A',
            'marca_id'     => $marca->id
        ]);
    }
}
