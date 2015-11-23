<?php

/**
 * @coversDefaultClass \App\IcecatCategoryFeatureGroup
 */
class IcecatCategoryFeatureGroupTest extends TestCase {

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsRequerido() {
        $icecat_category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->make();
        $icecat_id = $icecat_category_feature_group->icecat_id;
        unset($icecat_category_feature_group->icecat_id);
        $this->assertFalse($icecat_category_feature_group->isValid());
        $icecat_category_feature_group->icecat_id = $icecat_id;
        $this->assertTrue($icecat_category_feature_group->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsEntero() {
        $icecat_category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->make();
        $icecat_id = $icecat_category_feature_group->icecat_id;
        $icecat_category_feature_group->icecat_id = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_category_feature_group->isValid());
        $icecat_category_feature_group->icecat_id = $icecat_id;
        $this->assertTrue($icecat_category_feature_group->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsUnico() {
        $icecat_feature1 = factory(App\IcecatCategoryFeatureGroup::class)->create();
        $icecat_feature2 = factory(App\IcecatCategoryFeatureGroup::class)->make();
        $icecat_id = $icecat_feature2->icecat_id;
        $icecat_feature2->icecat_id = $icecat_feature1->icecat_id;
        $this->assertFalse($icecat_feature2->isValid());
        $icecat_feature2->icecat_id = $icecat_id;
        $this->assertTrue($icecat_feature2->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatCategoryIdEsEntero() {
        $icecat_category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->make();
        $icecat_category_id = $icecat_category_feature_group->icecat_category_id;
        $icecat_category_feature_group->icecat_category_id = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_category_feature_group->isValid());
        $icecat_category_feature_group->icecat_category_id = $icecat_category_id;
        $this->assertTrue($icecat_category_feature_group->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatFeatureGroupIdEsEntero() {
        $icecat_category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->make();
        $icecat_feature_group_id = $icecat_category_feature_group->icecat_feature_group_id;
        $icecat_category_feature_group->icecat_feature_group_id = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_category_feature_group->isValid());
        $icecat_category_feature_group->icecat_feature_group_id = $icecat_feature_group_id;
        $this->assertTrue($icecat_category_feature_group->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testCombinacionForeignKeysUnica() {
        $icecat_category_feature_group1 = factory(App\IcecatCategoryFeatureGroup::class)->create();
        $icecat_category_feature_group2 = factory(App\IcecatCategoryFeatureGroup::class)->make([
            'icecat_category_id'      => $icecat_category_feature_group1->icecat_category_id,
            'icecat_feature_group_id' => $icecat_category_feature_group1->icecat_feature_group_id,
        ]);
        $this->assertFalse($icecat_category_feature_group2->isValid());
        $icecat_category_feature_group2 = factory(App\IcecatCategoryFeatureGroup::class)->make([
            'icecat_feature_group_id' => $icecat_category_feature_group1->icecat_feature_group_id,
        ]);
        $this->assertTrue($icecat_category_feature_group2->isValid());
        $icecat_category_feature_group2 = factory(App\IcecatCategoryFeatureGroup::class)->make([
            'icecat_category_id' => $icecat_category_feature_group1->icecat_category_id,
        ]);
        $this->assertTrue($icecat_category_feature_group2->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testModeloEsActualizable() {
        $icecat_category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->create();
        $icecat_category_feature_group_stub = factory(App\IcecatCategoryFeatureGroup::class)->make();
        $icecat_category_feature_group->icecat_id = $icecat_category_feature_group_stub->icecat_id;
        $this->assertTrue($icecat_category_feature_group->save());
        $icecat_category_feature_group->icecat_category_id = $icecat_category_feature_group_stub->icecat_category_id;
        $icecat_category_feature_group->icecat_feature_group_id = $icecat_category_feature_group_stub->icecat_feature_group_id;
        $this->assertTrue($icecat_category_feature_group->save());
    }

    /**
     * @covers ::categoriesFeatures
     * @group icecat
     * @group relaciones
     */
    public function testCategoriesFeatures() {
        $category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->create();
        factory(App\IcecatCategoryFeature::class, 5)->create([
            'icecat_category_feature_group_id' => $category_feature_group->icecat_id
        ]);
        $result = $category_feature_group->categoriesFeatures;
        $this->assertCount(5, $result);
        $this->assertInstanceOf('App\IcecatCategoryFeature', $result[0]);
        $this->assertSame($category_feature_group->icecat_id, $result[0]->icecat_category_feature_group_id);
    }

    /**
     * @covers ::category
     * @group icecat
     * @group relaciones
     */
    public function testCategory() {
        $category = factory(App\IcecatCategory::class)->create();
        $category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->create([
            'icecat_category_id' => $category->icecat_id
        ]);
        $this->assertInstanceOf('App\IcecatCategory', $category_feature_group->category);
        $this->assertSame($category->icecat_id, $category_feature_group->category->icecat_id);
    }

    /**
     * @covers ::featureGroup
     * @group icecat
     * @group relaciones
     */
    public function testFeatureGroup() {
        $feature_group = factory(App\IcecatFeatureGroup::class)->create();
        $category_feature_group = factory(App\IcecatCategoryFeatureGroup::class)->create([
            'icecat_feature_group_id' => $feature_group->icecat_id
        ]);
        $this->assertInstanceOf('App\IcecatFeatureGroup', $category_feature_group->featureGroup);
        $this->assertSame($feature_group->icecat_id, $category_feature_group->featureGroup->icecat_id);
    }

}
