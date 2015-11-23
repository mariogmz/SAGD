<?php

/**
 * @coversDefaultClass \App\IcecatCategory
 */
class IcecatCategoryTest extends TestCase {

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsRequerido() {
        $icecat_category = factory(App\IcecatCategory::class)->make();
        $id = $icecat_category->icecat_id;
        unset($icecat_category->icecat_id);
        $this->assertFalse($icecat_category->isValid());
        $icecat_category->icecat_id = $id;
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsEntero() {
        $icecat_category = factory(App\IcecatCategory::class)->make([
            'icecat_id' => "I'm the one who knocks"
        ]);
        $this->assertFalse($icecat_category->isValid());
        $icecat_category->icecat_id = round(rand(1, 99999999));
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsUnico() {
        $icecat_category_1 = factory(App\IcecatCategory::class)->create();
        $icecat_category_2 = factory(App\IcecatCategory::class)->make([
            'icecat_id' => $icecat_category_1->icecat_id
        ]);
        $this->assertFalse($icecat_category_2->isValid());
        $icecat_category_2->icecat_id = round(rand(1, 99999999));
        $this->assertTrue($icecat_category_2->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testModeloEsActualizable() {
        $icecat_category = factory(App\IcecatCategory::class)->create();
        $icecat_category->name = 'Zegucom';
        $this->assertTrue(($icecat_category->isValid('update')));
        $this->assertTrue($icecat_category->save(), $icecat_category->errors);
        $icecat_category->fresh();
        $this->assertSame('Zegucom', $icecat_category->name);
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testNameEsRequerido() {
        $icecat_category = factory(App\IcecatCategory::class)->make();
        unset($icecat_category->name);
        $this->assertFalse($icecat_category->isValid());
        $icecat_category->name = 'Jesse Pinkman';
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testNameEsMaximoDe100Caracteres() {
        $icecat_category = factory(App\IcecatCategory::class, 'longname')->make();
        $this->assertFalse($icecat_category->isValid());
        $icecat_category->name = substr($icecat_category->name, 0, 99);
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testDescripcionEsOpcional() {
        $icecat_category = factory(App\IcecatCategory::class)->make();
        unset($icecat_category->description);
        $this->assertTrue($icecat_category->isValid());
        $icecat_category->description = 'This is dummy description';
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescripcionEsMaximoDe300Caracteres() {
        $icecat_category = factory(App\IcecatCategory::class, 'longdescription')->make();
        $this->assertFalse($icecat_category->isValid());
        $icecat_category->description = substr($icecat_category->description, 0, 299);
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testKeywordEsOpcional() {
        $icecat_category = factory(App\IcecatCategory::class)->make();
        unset($icecat_category->keyword);
        $this->assertTrue($icecat_category->isValid());
        $icecat_category->keyword = 'This is dummy keyword';
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     */
    public function testKeywordEsMaximo100Caracteres() {
        $icecat_category = factory(App\IcecatCategory::class, 'longkeyword')->make();
        $this->assertFalse($icecat_category->isValid());
        $icecat_category->keyword = substr($icecat_category->keyword, 0, 99);
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatCategoryPadreEsOpcional() {
        $icecat_category = factory(App\IcecatCategory::class)->make();
        $this->assertTrue($icecat_category->isValid());
        $icecat_category->icecat_parent_category_id = 1;
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testSubfamiliaIdEsOpcional() {
        $icecat_category = factory(App\IcecatCategory::class)->make();
        $this->assertTrue($icecat_category->isValid());
        $icecat_category->subfamilia_id = 1;
        $this->assertTrue($icecat_category->isValid());
    }

    /**
     * @covers ::subfamilia
     * @group relaciones
     * @group icecat
     */
    public function testSubfamilia() {
        $subfamilia = factory(App\Subfamilia::class)->create();
        $icecat_category = factory(App\IcecatCategory::class)->create([
            'subfamilia_id' => $subfamilia->id
        ]);
        $testSubfamilia = $icecat_category->subfamilia;
        $this->assertInstanceOf('App\Subfamilia', $testSubfamilia);
        $this->assertSame($subfamilia->id, $icecat_category->subfamilia->id);
    }

    /**
     * @covers ::categoriesFeatures
     * @group icecat
     * @grpup relaciones
     */
    public function testCategoriesFeatures() {
        $category = factory(App\IcecatCategory::class)->create();
        factory(App\IcecatCategoryFeature::class, 5)->create([
            'icecat_category_id' => $category->icecat_id
        ]);
        $this->assertCount(5, $category->categoriesFeatures);
        $this->assertInstanceOf('App\IcecatCategoryFeature', $category->categoriesFeatures[0]);
        $this->assertSame($category->icecat_id, $category->categoriesFeatures[0]->icecat_category_id);
    }


}
