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
        if (!file_exists('Icecat/category_features.xml')) {
            $this->icecat_feed->downloadAndDecode('category_features');
        }
        $this->assertGreaterThan(0, $this->icecat_feed->getCategoriesFeatureGroups());
        $this->assertFileExists('Icecat/category_feature_groups.json');
    }

    /**
     * @covers ::getCategoriesFeatures
     * @group icecat
     * @covers ::parseCategoryFeatureNode
     */
    public function testGetCategoriesFeatures() {
        if (!file_exists('Icecat/category_features.xml')) {
            $this->icecat_feed->downloadAndDecode('category_features');
        }
        $this->assertGreaterThan(0, $this->icecat_feed->getCategoriesFeatures());
        $this->assertFileExists('Icecat/categories_features.json');
    }

    /**
     * @covers ::getProductSheet
     * @covers ::downloadSheet
     * @covers ::parseProductSheet
     * @group icecat
     */
    public function testGetProductSheet() {
        if (empty($marca = App\Marca::whereNombre('hp')->first())) {
            $marca = factory(App\Marca::class)->create([
                'nombre' => 'hp'
            ]);
        }
        if (empty($supplier = App\IcecatSupplier::whereName('hp')->first())) {
            factory(App\IcecatSupplier::class)->create([
                'name'     => 'hp',
                'marca_id' => $marca->id
            ]);
        }

        $producto = factory(App\Producto::class)->create([
            'numero_parte' => 'CB049A',
            'marca_id'     => $marca->id
        ]);
        $sheet_data = $this->icecat_feed->getProductSheet($producto);
        $this->assertNotFalse($sheet_data);
    }

    /**
     * @covers ::getProductSheet
     * @covers ::downloadSheet
     * @covers ::parseProductSheet
     * @group icecat
     */
    public function testGetProductSheetNotExists() {
        $marca = factory(App\Marca::class)->create([
            'nombre' => 'wiu'
        ]);
        factory(App\IcecatSupplier::class)->create([
            'marca_id' => $marca->id
        ]);
        $producto = factory(App\Producto::class)->create([
            'numero_parte' => 'aaaa',
            'marca_id'     => $marca->id
        ]);
        $sheet_data = $this->icecat_feed->getProductSheet($producto);
        $this->assertFalse($sheet_data);
    }

    /**
     * @covers ::getProductSheet
     * @covers ::downloadSheet
     * @covers ::parseProductSheet
     * @group icecat
     */
    public function testGetProductSheetOnDisk() {
        if (empty($marca = App\Marca::whereNombre('hp')->first())) {
            $marca = factory(App\Marca::class)->create([
                'nombre' => 'hp'
            ]);
        }
        if (empty($supplier = App\IcecatSupplier::whereName('hp')->first())) {
            factory(App\IcecatSupplier::class)->create([
                'name'     => 'hp',
                'marca_id' => $marca->id
            ]);
        }

        $producto = factory(App\Producto::class)->create([
            'numero_parte' => 'CB049A',
            'marca_id'     => $marca->id
        ]);
        $sheet_data = $this->icecat_feed->getProductSheet($producto, true);
        $this->assertNotFalse($sheet_data);
        $this->assertFileExists('Icecat/CB049A.xml');
    }

    /**
     * @covers ::downloadSheetRaw
     * @group icecat
     */
    public function testDownloadSheetRaw() {
        $xml = $this->icecat_feed->downloadSheetRaw('CB049A','hp', true);
        $this->assertFileExists('Icecat/CB049A.xml');
        $this->assertXmlStringEqualsXmlFile('Icecat/CB049A.xml',$xml);
    }

}
