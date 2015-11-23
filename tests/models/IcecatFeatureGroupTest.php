<?php

/**
 * @coversDefaultClass \App\IcecatFeatureGroup
 */
class IcecatFeatureGroupTest extends TestCase {

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsRequerido() {
        $icecat_feature = factory(App\IcecatFeatureGroup::class)->make();
        $icecat_id = $icecat_feature->icecat_id;
        unset($icecat_feature->icecat_id);
        $this->assertFalse($icecat_feature->isValid());
        $icecat_feature->icecat_id = $icecat_id;
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsEntero() {
        $icecat_feature = factory(App\IcecatFeatureGroup::class)->make();
        $icecat_id = $icecat_feature->icecat_id;
        $icecat_feature->icecat_id = 'Shut up woman and get on my horse';
        $this->assertFalse($icecat_feature->isValid());
        $icecat_feature->icecat_id = $icecat_id;
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsUnico() {
        $icecat_feature1 = factory(App\IcecatFeatureGroup::class)->create();
        $icecat_feature2 = factory(App\IcecatFeatureGroup::class)->make();
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
    public function testNameEsRequerido() {
        $icecat_feature = factory(App\IcecatFeatureGroup::class)->make();
        unset($icecat_feature->name);
        $this->assertFalse($icecat_feature->isValid());
        $icecat_feature->name = 'Anthony Hoskins';
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testNameEsMaximo70Caracteres() {
        $icecat_feature = factory(App\IcecatFeatureGroup::class, 'longname')->make();
        $this->assertFalse($icecat_feature->isValid());
        $icecat_feature->name = 'Anthony Hoskins';
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @covers ::categoriesFeatureGroups
     * @group icecat
     * @group relaciones
     */
    public function testCategoriesFeatureGroups(){
        $this->markTestIncomplete('Not implemented yet.');
    }

}
