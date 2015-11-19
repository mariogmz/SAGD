<?php

/**
 * @coversDefaultClass \App\IcecatFeature
 */
class IcecatFeatureTest extends TestCase {

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsRequerido() {
        $icecat_feature = factory(App\IcecatFeature::class)->make();
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
        $icecat_feature = factory(App\IcecatFeature::class)->make();
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
        $icecat_feature1 = factory(App\IcecatFeature::class)->create();
        $icecat_feature2 = factory(App\IcecatFeature::class)->make();
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
    public function testTypeEsOpcional() {
        $icecat_feature = factory(App\IcecatFeature::class)->make();
        unset($icecat_feature->descripcion);
        $this->assertTrue($icecat_feature->isValid());
        $icecat_feature->descripcion = 'Bitchbox';
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testTypeEsMaximo45Caracteres() {
        $icecat_feature = factory(App\IcecatFeature::class, 'longtype')->make();
        $this->assertFalse($icecat_feature->isValid());
        $icecat_feature->type = 'Bitchbox';
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testNameEsRequerido() {
        $icecat_feature = factory(App\IcecatFeature::class)->make();
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
        $icecat_feature = factory(App\IcecatFeature::class, 'longname')->make();
        $this->assertFalse($icecat_feature->isValid());
        $icecat_feature->name = 'Anthony Hoskins';
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testDescriptionEsOpcional() {
        $icecat_feature = factory(App\IcecatFeature::class)->make();
        unset($icecat_feature->description);
        $this->assertTrue($icecat_feature->isValid());
        $icecat_feature->description = 'Icecat sucks';
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testDescriptionEsMaximo100Caracteres() {
        $icecat_feature = factory(App\IcecatFeature::class, 'longdescription')->make();
        $this->assertFalse($icecat_feature->isValid());
        $icecat_feature->description = 'Icecat Sucks';
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testMeasureEsOpcional() {
        $icecat_feature = factory(App\IcecatFeature::class)->make();
        unset($icecat_feature->measure);
        $this->assertTrue($icecat_feature->isValid());
        $icecat_feature->measure = 'cms';
        $this->assertTrue($icecat_feature->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testMeasureEsMaximo10Caracteres() {
        $icecat_feature = factory(App\IcecatFeature::class, 'longmeasure')->make();
        $this->assertFalse($icecat_feature->isValid());
        $icecat_feature->measure = 'cm';
        $this->assertTrue($icecat_feature->isValid());
    }

}
