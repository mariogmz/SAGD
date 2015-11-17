<?php

/**
 * @coversDefaultClass \App\IcecatSupplier
 */
class IcecatSupplierTest extends TestCase {

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIceCatIdEsRequerido() {
        $icecat_supplier = factory(App\IcecatSupplier::class)->make();
        unset($icecat_supplier->icecat_id);
        $this->assertFalse($icecat_supplier->isValid());
        $icecat_supplier->icecat_id = round(rand(1, 99999999));
        $this->assertTrue($icecat_supplier->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatIdEsEntero() {
        $icecat_supplier = factory(App\IcecatSupplier::class)->make([
            'icecat_id' => 'hello_again_potatoe'
        ]);
        $this->assertFalse($icecat_supplier->isValid());
        $icecat_supplier->icecat_id = round(rand(1, 99999999));
        $this->assertTrue($icecat_supplier->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIceCatIdEsUnico() {
        $primer_ics = factory(App\IcecatSupplier::class)->create();
        $segundo_ics = factory(App\IcecatSupplier::class)->make([
            'icecat_id' => $primer_ics->icecat_id
        ]);
        $this->assertFalse($segundo_ics->isValid());
        $segundo_ics->icecat_id = round(rand(0, 1000)) + $primer_ics->icecat_id;
        $this->assertTrue($segundo_ics->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testModeloEsActualizable() {
        $icecat_supplier = factory(App\IcecatSupplier::class)->create();
        $icecat_supplier->logo_url = 'http://images.google.com/algo';
        $this->assertTrue($icecat_supplier->isValid('update'));
        $this->assertTrue($icecat_supplier->save());
        $icecat_supplier->fresh();
        $this->assertSame('http://images.google.com/algo', $icecat_supplier->logo_url);
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testNameEsRequerido() {
        $icecat_supplier = factory(App\IcecatSupplier::class)->make();
        unset($icecat_supplier->name);
        $this->assertFalse($icecat_supplier->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function test_logo_url_es_opcional() {
        $icecat_supplier = factory(App\IcecatSupplier::class)->make();
        unset($icecat_supplier->logo_url);
        $this->assertTrue($icecat_supplier->isValid());
    }

}
