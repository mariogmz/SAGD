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
        $this->assertTrue($icecat_category->save());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testNameEsRequerido() {
        $icecat_category = factory(App\IcecatCategory::class)->make();
        unset($icecat_category->name);
        $this->assertTrue($icecat_category->isValid());
        $icecat_category->name = 'Jesse Pinkman';
        $this->assertFalse($icecat_category->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testNameEsMaximoDe100Caracteres() {

    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testDescripcionEsOpcional() {

    }

    /**
     * @coversNothing
     */
    public function testDescripcionEsMaximoDe300Caracteres() {

    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testKeywordEsOpcional() {

    }

    /**
     * @coversNothing
     */
    public function testKeywordEsMaximo100Caracteres() {

    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatCategoryPadreEsOpcional() {

    }

}
