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
        $icecat_feature_group_id  = $icecat_category_feature_group->icecat_feature_group_id ;
        $icecat_category_feature_group->icecat_feature_group_id  = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_category_feature_group->isValid());
        $icecat_category_feature_group->icecat_feature_group_id  = $icecat_feature_group_id ;
        $this->assertTrue($icecat_category_feature_group->isValid());
    }

}
