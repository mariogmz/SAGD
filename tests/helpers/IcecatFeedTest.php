<?php

/**
 * @coversDefaultClass \Sagd\IcecatFeed
 */
class IcecatFeedTest extends TestCase {

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
     * @group icecat
     */
    public function testDownloadAndDecodeUndecoded() {
        $this->icecat_feed->downloadAndDecode('relations');
        $this->assertFileExists('Icecat/relations.xml');
    }

    /**
     * @covers ::downloadAndDecode
     * @group icecat
     */
    public function testDownloadAndDecodeGzipped() {
        $this->icecat_feed->downloadAndDecode('suppliers');
        $this->assertFileExists('Icecat/suppliers.xml');
    }

    /**
     * @covers ::downloadAndDecode
     * @group icecat
     * @expectedException ErrorException
     */
    public function testDownloadAndDecodeOnUndefinedRefThrowsErrorException() {
        $this->icecat_feed->downloadAndDecode('undefined');
    }

    /**
     * @covers ::downloadAndDecode
     * @group icecat
     * @expectedException ErrorException
     */
    public function testDownloadAndDecodeOnFileNotFound() {
        $this->icecat_feed->downloadAndDecode('not_found');
    }

    /**
     * @covers ::getCategories
     * @group icecat
     * @covers ::parseCategoryNode
     */
    public function testGetCategories() {
        $this->icecat_feed->downloadAndDecode('categories');
        $this->assertGreaterThan(0, $this->icecat_feed->getCategories());
        $this->assertFileExists('Icecat/categories.json');
    }

    /**
     * @covers ::getSuppliers
     * @group icecat
     * @covers ::parseSupplierNode
     */
    public function testGetSuppliers() {
        $this->icecat_feed->downloadAndDecode('suppliers');
        $this->assertGreaterThan(0, $this->icecat_feed->getSuppliers());
        $this->assertFileExists('Icecat/suppliers.json');
    }

    /**
     * @covers ::getFeature
     * @group icecat
     * @covers ::parseFeatureNode
     */
    public function testGetFeatures() {
        $this->icecat_feed->downloadAndDecode('features');
        $this->assertGreaterThan(0, $this->icecat_feed->getFeatures());
        $this->assertFileExists('Icecat/features.json');
    }

    /**
     * @covers ::getFeatureGroups
     * @covers ::parseFeatureGroupNode
     */
    public function testGetFeatureGroups() {
        $this->icecat_feed->downloadAndDecode('feature_groups');
        $this->assertGreaterThan(0, $this->icecat_feed->getFeatureGroups());
        $this->assertFileExists('Icecat/feature_groups.json');
    }


    /**
     * @covers ::getCategoriesFeatureGroups
     * @group icecat
     * @covers ::parseCategoryFeatureGroupNode
     */
    public function testGetCategoriesFeatureGroups() {
        $this->assertGreaterThan(0, $this->icecat_feed->getCategoriesFeatureGroups());
        $this->assertFileExists('Icecat/category_feature_groups.json');
    }

    /**
     * @covers ::getCategoriesFeatures
     * @group icecat
     * @covers ::parseCategoryFeatureNode
     */
    public function testgetCategoriesFeatures() {
        $this->assertGreaterThan(0, $this->icecat_feed->getCategoriesFeatures());
        $this->assertFileExists('Icecat/category_feature_groups.json');
    }

}
