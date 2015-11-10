<?php

/**
 * @coversDefaultClass \Sagd\IcecatFeed
 */
class IcecatFeedest extends TestCase {

    protected $icecat_feed;

    public function setUp() {
        parent::setUp();
        $this->icecat_feed = new \Sagd\IcecatFeed();
    }

    public function tearDown() {
        parent::tearDown();
        array_map('unlink', glob('Icecat/*.xml'));
        array_map('unlink', glob('Icecat/*.json'));
    }

    /**
     * @covers ::downloadAndDecode
     */
    public function testDownloadAndDecodeUndecoded() {
        $this->icecat_feed->downloadAndDecode('relations');
        $this->assertFileExists('Icecat/relations.xml');
    }

    /**
     * @covers ::downloadAndDecode
     */
    public function testDownloadAndDecodeGzipped() {
        $this->icecat_feed->downloadAndDecode('suppliers');
        $this->assertFileExists('Icecat/suppliers.xml');
    }

    /**
     * @covers ::downloadAndDecode
     * @expectedException ErrorException
     */
    public function testDownloadAndDecodeOnUndefinedRefThrowsErrorException() {
        $this->icecat_feed->downloadAndDecode('undefined');
    }

    /**
     * @covers ::downloadAndDecode
     * @expectedException ErrorException
     */
    public function testDownloadAndDecodeOnFileNotFound() {
        $this->icecat_feed->downloadAndDecode('not_found');
    }

    /**
     * @covers ::getCategories
     * @covers ::parseCategoryNode
     */
    public function testGetCategories() {
        $this->icecat_feed->downloadAndDecode('categories');
        $this->assertGreaterThan(0,$this->icecat_feed->getCategories('categories'));
        $this->assertFileExists('Icecat/categories.json');
    }

    /**
     * @covers ::getFeature
     * @covers ::parseFeatureNode
     */
    public function testGetFeatures() {
        $this->icecat_feed->downloadAndDecode('features');
        $this->assertGreaterThan(0,$this->icecat_feed->getFeatures('features'));
        $this->assertFileExists('Icecat/features.json');
    }

    /**
     * @covers ::getFeatureGroups
     * @covers ::parseFeatureGroupNode
     */
    public function testGetFeatureGroups() {
        $this->icecat_feed->downloadAndDecode('feature_groups');
        $this->assertGreaterThan(0,$this->icecat_feed->getFeatureGroups('feature_groups'));
        $this->assertFileExists('Icecat/feature_groups.json');
    }

    /**
     * @covers ::getSuppliers
     * @covers ::parseSupplierNode
     */
    public function testGetSuppliers() {
        $this->icecat_feed->downloadAndDecode('suppliers');
        $this->assertGreaterThan(0,$this->icecat_feed->getSuppliers('suppliers'));
        $this->assertFileExists('Icecat/suppliers.json');
    }

}
