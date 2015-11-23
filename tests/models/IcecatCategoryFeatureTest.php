<?php

/**
 * @coversDefaultClass \App\IcecatCategoryFeature
 */
class IcecatCategoryFeatureTest extends TestCase {

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsRequerido() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->make();
        $icecat_id = $icecat_category_feature->icecat_id;
        unset($icecat_category_feature->icecat_id);
        $this->assertFalse($icecat_category_feature->isValid());
        $icecat_category_feature->icecat_id = $icecat_id;
        $this->assertTrue($icecat_category_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsEntero() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->make();
        $icecat_id = $icecat_category_feature->icecat_id;
        $icecat_category_feature->icecat_id = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_category_feature->isValid());
        $icecat_category_feature->icecat_id = $icecat_id;
        $this->assertTrue($icecat_category_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsUnico() {
        $icecat_feature1 = factory(App\IcecatCategoryFeature::class)->create();
        $icecat_feature2 = factory(App\IcecatCategoryFeature::class)->make();
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
    public function testIcecatCategoryFeatureGroupIdEsRequerido() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->make();
        $icecat_category_feature_group_id = $icecat_category_feature->icecat_category_feature_group_id;
        unset($icecat_category_feature->icecat_category_feature_group_id);
        $this->assertFalse($icecat_category_feature->isValid());
        $icecat_category_feature->icecat_category_feature_group_id = $icecat_category_feature_group_id;
        $this->assertTrue($icecat_category_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatCategoryFeatureGroupIdEsEntero() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->make();
        $icecat_category_feature_group_id = $icecat_category_feature->icecat_category_feature_group_id;
        $icecat_category_feature->icecat_category_feature_group_id = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_category_feature->isValid());
        $icecat_category_feature->icecat_category_feature_group_id = $icecat_category_feature_group_id;
        $this->assertTrue($icecat_category_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatCategoryIdEsRequerido() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->make();
        $icecat_category_id = $icecat_category_feature->icecat_category_id;
        unset($icecat_category_feature->icecat_category_id);
        $this->assertFalse($icecat_category_feature->isValid());
        $icecat_category_feature->icecat_category_id = $icecat_category_id;
        $this->assertTrue($icecat_category_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatCategoryIdEsEntero() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->make();
        $icecat_category_id = $icecat_category_feature->icecat_category_id;
        $icecat_category_feature->icecat_category_id = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_category_feature->isValid());
        $icecat_category_feature->icecat_category_id = $icecat_category_id;
        $this->assertTrue($icecat_category_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatFeatureIdEsRequerido() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->make();
        $icecat_feature_id = $icecat_category_feature->icecat_feature_id;
        unset($icecat_category_feature->icecat_feature_id);
        $this->assertFalse($icecat_category_feature->isValid());
        $icecat_category_feature->icecat_feature_id = $icecat_feature_id;
        $this->assertTrue($icecat_category_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatFeatureIdEsEntero() {
        $icecat_category_feature = factory(App\IcecatCategoryFeature::class)->make();
        $icecat_feature_id = $icecat_category_feature->icecat_feature_id;
        $icecat_category_feature->icecat_feature_id = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_category_feature->isValid());
        $icecat_category_feature->icecat_feature_id = $icecat_feature_id;
        $this->assertTrue($icecat_category_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testCombinacionForeignKeysUnica() {
        $icecat_category_feature1 = factory(App\IcecatCategoryFeature::class)->create();
        $icecat_category_feature2 = factory(App\IcecatCategoryFeature::class)->make([
            'icecat_category_feature_group_id' => $icecat_category_feature1->icecat_category_feature_group_id,
            'icecat_category_id'               => $icecat_category_feature1->icecat_category_id,
            'icecat_feature_id'                => $icecat_category_feature1->icecat_feature_id
        ]);
        $this->assertFalse($icecat_category_feature2->isValid());
        $icecat_category_feature2 = factory(App\IcecatCategoryFeature::class)->make([
            'icecat_category_id' => $icecat_category_feature1->icecat_category_id,
            'icecat_feature_id'  => $icecat_category_feature1->icecat_feature_id
        ]);
        $this->assertTrue($icecat_category_feature2->isValid());
        $icecat_category_feature2 = factory(App\IcecatCategoryFeature::class)->make([
            'icecat_category_feature_group_id' => $icecat_category_feature1->icecat_category_feature_group_id,
            'icecat_feature_id'                => $icecat_category_feature1->icecat_feature_id
        ]);
        $this->assertTrue($icecat_category_feature2->isValid());
        $icecat_category_feature2 = factory(App\IcecatCategoryFeature::class)->make([
            'icecat_category_feature_group_id' => $icecat_category_feature1->icecat_category_feature_group_id,
            'icecat_category_id'               => $icecat_category_feature1->icecat_category_id,
        ]);
        $this->assertTrue($icecat_category_feature2->isValid());
    }

}
