<?php

/**
 * @coversDefaultClass \App\\App\FichaCaracteristica
 */
class FichaCaracteristicaTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testFichaIdRequerido() {
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->make();
        unset($ficha_caracteristica->ficha_id);
        $this->assertFalse($ficha_caracteristica->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFichaIdEntero() {
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->make();
        $ficha_id = $ficha_caracteristica->ficha_id;
        $ficha_caracteristica->ficha_id = 'texto';
        $this->assertFalse($ficha_caracteristica->isValid());
        $ficha_caracteristica->ficha_id = $ficha_id;
        $this->assertTrue($ficha_caracteristica->isValid());
    }


    /**
     * @coversNothing
     */
    public function testCategoryFeatureIdEntero() {
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->make();
        $category_feature_id = $ficha_caracteristica->category_feature_id;
        $ficha_caracteristica->category_feature_id = 'texto';
        $this->assertFalse($ficha_caracteristica->isValid());
        $ficha_caracteristica->category_feature_id = $category_feature_id;
        $this->assertTrue($ficha_caracteristica->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCategoryFeatureIdRequerido() {
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->make();
        unset($ficha_caracteristica->category_feature_id);
        $this->assertFalse($ficha_caracteristica->isValid());
    }

    /**
     * @coversNohing
     */
    public function testCombinacionForeignKeysEsUnica() {
        factory(App\FichaCaracteristica::class)->create([
            'ficha_id'            => 1,
            'category_feature_id' => 1
        ]);
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->make([
            'ficha_id'            => 1,
            'category_feature_id' => 1
        ]);
        $this->assertFalse($ficha_caracteristica->isValid());

        $ficha_caracteristica->ficha_id = random_int(2, 9999);
        $this->assertTrue($ficha_caracteristica->isValid());

        $ficha_caracteristica->ficha_id = 1;
        $ficha_caracteristica->category_feature_id = random_int(2, 9999);
        $this->assertTrue($ficha_caracteristica->isValid());

        $ficha_caracteristica->ficha_id = random_int(2, 9999);
        $this->assertTrue($ficha_caracteristica->isValid());
    }


    /**
     * @coversNothing
     */
    public function testModeloEsActualizable() {
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->create();
        $ficha_caracteristica->valor = 'valor nuevo';
        $this->assertTrue($ficha_caracteristica->save());
    }

    /**
     * @coversNothing
     */
    public function testValorEsRequerido() {
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->make();
        unset($ficha_caracteristica->valor);
        $this->assertFalse($ficha_caracteristica->isValid());
    }

    /**
     * @coversNothing
     */
    public function testValorPresentacionEsOpcional() {
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->make();
        unset($ficha_caracteristica->valor_presentacion);
        $this->assertTrue($ficha_caracteristica->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCuandoSeActualizaUnValorSeActualizaTimestampDeFicha() {
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->create();
        $ficha_caracteristica->valor = 'valor nuevo';
        $this->assertTrue($ficha_caracteristica->save());
        $this->assertNotSame($ficha_caracteristica->ficha->created_at, $ficha_caracteristica->ficha->updated_at);
    }

    /**
     * @covers ::ficha
     * @group relaciones
     */
    public function testFicha() {
        $ficha = factory(App\Ficha::class)->create();
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->create([
            'ficha_id' => $ficha->id
        ]);
        $result = $ficha_caracteristica->ficha;
        $this->assertInstanceOf('App\Ficha', $result);
        $this->assertEquals($ficha->id, $result->id);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto() {
        $ficha = factory(App\Ficha::class)->create();
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->create([
            'ficha_id' => $ficha->id
        ]);
        $result = $ficha_caracteristica->producto;
        $this->assertInstanceOf('App\Producto', $result);
        $this->assertEquals($ficha->producto_id, $result->id);
    }

    /**
     * @covers ::categoryFeature
     * @group relaciones
     * @group icecat
     */
    public function testCategoryFeature() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->create();
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->create([
            'category_feature_id' => $icecat_category_feature->id
        ]);
        $result = $ficha_caracteristica->categoryFeature;
        $this->assertInstanceOf('App\IcecatCategoryFeature', $result);
        $this->assertEquals($icecat_category_feature->id, $result->id);
    }

    /**
     * @covers ::category
     * @group relaciones
     * @group icecat
     */
    public function testCategory() {
        $icecat_category = factory(App\IcecatCategory::class)->create();
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->create([
            'icecat_category_id' => $icecat_category->icecat_id
        ]);
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->create([
            'category_feature_id' => $icecat_category_feature->id
        ]);
        $result = $ficha_caracteristica->category;
        $this->assertInstanceOf('App\IcecatCategory', $result);
        $this->assertSame($icecat_category->id, $result->id);
    }

    /**
     * @covers ::feature
     * @group relaciones
     * @group icecat
     */
    public function testFeature() {
        $icecat_feature = factory(App\IcecatFeature::class)->create();
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->create([
            'icecat_feature_id' => $icecat_feature->icecat_id
        ]);
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->create([
            'category_feature_id' => $icecat_category_feature->id
        ]);
        $result = $ficha_caracteristica->feature;
        $this->assertInstanceOf('App\IcecatFeature', $result);
        $this->assertSame($icecat_feature->id, $result->id);
    }

    /**
     * @covers ::featureGroup
     * @group relaciones
     * @group icecat
     */
    public function testFeaturegroup(){
        $icecat_feature_group = factory(App\IcecatFeatureGroup::class)->create();
        $icecat_category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->create([
            'icecat_feature_group_id' => $icecat_feature_group->icecat_id
        ]);
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->create([
            'icecat_category_feature_group_id' => $icecat_category_feature_group->icecat_id
        ]);
        $ficha_caracteristica = factory(App\FichaCaracteristica::class)->create([
            'category_feature_id' => $icecat_category_feature->id
        ]);
        $result = $ficha_caracteristica->featureGroup;
        $this->assertInstanceOf('App\IcecatFeatureGroup', $result);
        $this->assertSame($icecat_feature_group->id, $result->id);
    }
}
