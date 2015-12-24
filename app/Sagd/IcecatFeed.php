<?php

namespace Sagd;


use App;
use ErrorException;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Parser;
use Prewk\XmlStringStreamer\Stream;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

Class IcecatFeed {

    private $username;
    private $password;
    private $refs_endpoint;
    private $refs;
    private $sheet_endpoint;

    public function __construct() {
        $this->username = getenv('ICECAT_USERNAME');
        $this->password = getenv('ICECAT_PASSWORD');
        $this->refs_endpoint = "https://{$this->username}:{$this->password}@data.icecat.biz/export/level4/refs/";
        $this->refs = [
            'categories'        => 'CategoriesList.xml.gz',
            'category_features' => 'CategoryFeaturesList.xml.gz',
            'features'          => 'FeaturesList.xml.gz',
            'feature_groups'    => 'FeatureGroupsList.xml.gz',
            'languages'         => 'LanguageList.xml.gz',
            'measures'          => 'MeasuresLists.xml.gz',
            'relations'         => 'RelationsList.xml',
            'suppliers'         => 'SuppliersList.xml.gz',
            'not_found'         => 'file.xml'
        ];
        $this->sheet_endpoint = "https://{$this->username}:{$this->password}@data.icecat.biz/xml_s3/xml_server3.cgi?prod_id={numero_parte};vendor={marca};lang=es;output=productxml";
    }

    /**
     * ************************************* GET METHODS *************************************************
     */

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/CategoriesList.xml.gz" to
     * a PHP associative array and the saves it to a .json file
     * @param bool $get_array
     * @param bool $with_parent
     * @return array
     */
    public function getCategories($get_array = false, $with_parent = false) {
        $icecat_categories = [];
        $stream = new Stream\File('Icecat/categories.xml', 1024);
        $parser = new Parser\StringWalker([
            'captureDepth' => 4,
        ]);

        $streamer = new XmlStringStreamer($parser, $stream);

        // Iterate over each one of the categories on the XML file
        // each $node is in fact a category
        while ($node = $streamer->getNode()) {
            $category = simplexml_load_string($node);
            $result = $this->parseCategoryNode($category, $with_parent);
            if ($result) {
                array_push($icecat_categories, $result);
            }
        }

        return $get_array ? $icecat_categories : file_put_contents('Icecat/categories.json', json_encode($icecat_categories, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/SuppliersList.xml.gz" to
     * a PHP associative array and then saves it to a .json file
     * @param bool $get_array
     * @return int | array
     */
    public function getSuppliers($get_array = false) {
        $icecat_suppliers = [];
        $stream = new Stream\File('Icecat/suppliers.xml', 1024);
        $parser = new Parser\UniqueNode([
            'uniqueNode'        => 'Supplier',
            'checkShortClosing' => true
        ]);

        $streamer = new XmlStringStreamer($parser, $stream);

        while ($node = $streamer->getNode()) {
            $group = simplexml_load_string($node);
            $result = $this->parseSupplierNode($group);
            if ($result) {
                array_push($icecat_suppliers, $result);
            }
        }

        return $get_array ? $icecat_suppliers : file_put_contents('Icecat/suppliers.json', json_encode($icecat_suppliers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/CategoryFeaturesList.xml.gz" to
     * a PHP associative array and then saves it to a .json file
     * @param bool $get_array
     * @return int | array
     */
    public function getFeatures($get_array = false) {
        $icecat_features = [];
        $stream = new Stream\File('Icecat/features.xml', 1024);
        $parser = new Parser\StringWalker([
            'captureDepth' => 4,
        ]);

        $streamer = new XmlStringStreamer($parser, $stream);

        // Iterate over each one of the features on the XML file
        // each $node is in fact a category
        while ($node = $streamer->getNode()) {
            $category = simplexml_load_string($node);
            $result = $this->parseFeatureNode($category);
            if ($result) {
                array_push($icecat_features, $result);
            }
        }

        return $get_array ? $icecat_features : file_put_contents('Icecat/features.json', json_encode($icecat_features, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/FeatureGroupList.xml.gz" to
     * a PHP associative array and then saves it to a .json file
     * @param bool $get_array
     * @return int | array
     */
    public function getFeatureGroups($get_array = false) {
        $icecat_feature_groups = [];
        $stream = new Stream\File('Icecat/feature_groups.xml', 1024);
        $parser = new Parser\StringWalker([
            'captureDepth' => 4
        ]);

        $streamer = new XmlStringStreamer($parser, $stream);

        while ($node = $streamer->getNode()) {
            $group = simplexml_load_string($node);
            $result = $this->parseFeatureGroupNode($group);
            if ($result) {
                array_push($icecat_feature_groups, $result);
            }
        }

        return $get_array ? $icecat_feature_groups : file_put_contents('Icecat/feature_groups.json', json_encode($icecat_feature_groups, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/CategoryFeaturesList.xml.gz" to
     * and obtains the relationship between categories and feature groups from Icecat
     * @param bool $get_array
     * @return int | array
     */
    public function getCategoriesFeatureGroups($get_array = false) {
        $icecat_category_feature_groups = [];
        $stream = new Stream\File('Icecat/categories_features.xml', 1024);
        $parser = new Parser\StringWalker([
            'captureDepth' => 4
        ]);

        $streamer = new XmlStringStreamer($parser, $stream);

        while ($node = $streamer->getNode()) {
            $category = simplexml_load_string($node);
            $result = $this->parseCategoryFeatureGroupNode($category);
            if ($result) {
                $icecat_category_feature_groups = array_merge($icecat_category_feature_groups, $result);
            }
        }

        return $get_array ? $icecat_category_feature_groups : file_put_contents('Icecat/category_feature_groups.json', json_encode($icecat_category_feature_groups, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/CategoryFeaturesList.xml.gz" to
     * and obtains the relationship between categories and features from Icecat
     * @param bool $get_array
     * @return int | array
     */
    public function getCategoriesFeatures($get_array = false) {
        $icecat_category_feature_groups = [];
        $stream = new Stream\File('Icecat/categories_features.xml', 1024);
        $parser = new Parser\StringWalker([
            'captureDepth' => 4
        ]);

        $streamer = new XmlStringStreamer($parser, $stream);

        while ($node = $streamer->getNode()) {
            $category = simplexml_load_string($node);
            $result = $this->parseCategoryFeatureNode($category);
            if ($result) {
                $icecat_category_feature_groups = array_merge($icecat_category_feature_groups, $result);
            }
        }

        return $get_array ? $icecat_category_feature_groups : file_put_contents('Icecat/categories_features.json', json_encode($icecat_category_feature_groups, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/CategoryFeaturesList.xml.gz" to
     * and obtains the relationship between features and their groups from Icecat
     * @param bool $get_array
     * @return int | array
     */
    public function getFeatureGroupsFeatures($get_array = false) {
        $icecat_category_feature_groups = [];
        $stream = new Stream\File('Icecat/categories_features.xml', 1024);
        $parser = new Parser\StringWalker([
            'captureDepth' => 4
        ]);

        $streamer = new XmlStringStreamer($parser, $stream);

        if (file_exists('Icecat/category_feature_groups.json')) {
            $categories_feature_groups = json_decode(file_get_contents('Icecat/category_feature_groups.json'));
        } else {
            $categories_feature_groups = $this->getCategoryFeatureGroups(true);
        }

        if (count($categories_feature_groups) > 0) {
            reindexar('icecat_id', $categories_feature_groups);

            while ($node = $streamer->getNode()) {
                $category = simplexml_load_string($node);
                $result = $this->parseFeatureGroupFeatureNode($category, $categories_feature_groups);
                if ($result) {
                    $icecat_category_feature_groups = array_merge($icecat_category_feature_groups, $result);
                }
            }

        }

        return $get_array ? $icecat_category_feature_groups : file_put_contents('Icecat/feature_groups_features.json', json_encode($icecat_category_feature_groups, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Downloads and decodes a requested file from https://data.icecat.biz/export/level4/refs/ , if file
     * was encoded with gzip, this method decodes it and saves the output into a file under the next path:
     *      /Icecat/{$ref_name}.xml
     * If the ref_name is not defined this method will throw an ErrorException
     * @param string $ref_name
     * @throws ErrorException | FileNotFoundException
     */
    public function downloadAndDecode($ref_name) {
        if (isset($this->refs[$ref_name])) {
            if ($ref_name == 'category_features') {
                $this->downloadAndDecodeCategoriesFeatures();
            } elseif ($ref_name == 'features'){
                $this->downloadAndDecodeFeatures();
            } else {
                $xml = file_get_contents($this->refs_endpoint . $this->refs[$ref_name]);
                if ($xml === false) {
                    throw new FileNotFoundException('File ' . $this->refs_endpoint . $this->refs[$ref_name] . ' does not exists.');
                } else {
                    if (strpos($this->refs[$ref_name], '.gz')) {
                        $xml = gzdecode($xml);
                    }
                    if (!file_exists('Icecat')) {
                        mkdir('Icecat', 0777, true);
                    }
                    file_put_contents("Icecat/{$ref_name}.xml", $xml);
                }
            }
        } else {
            throw new ErrorException("Unknown Icecat reference file, not found on index: {$ref_name}.");
        }
    }

    /**
     * *********************************** PRODUCT METHODS ***********************************************
     */

    /**
     * @param App\Producto $product
     * @param bool|false $save
     * @return array|bool
     */
    public function getProductSheet(App\Producto $product, $save = false) {
        if (!empty($xml = $this->downloadSheet($product, $save))) {
            return $this->parseProductSheet($xml);
        } else {
            return false;
        }
    }

    /**
     * @param string $numero_parte
     * @param int $marca_id
     * @return array|bool
     */
    public function getProductSheetRaw($numero_parte, $marca_id) {
        $marca = App\Marca::find($marca_id);
        if (!empty($marca)) {
            foreach ($marca->icecatSuppliers as $icecat_supplier) {
                $xml = $this->downloadSheetRaw($numero_parte, $icecat_supplier->name);
                if (!empty($xml)) {
                    return $this->prettySheet($this->parseProductSheet($xml));
                }
            }
        }

        return false;
    }

    /**
     * This method search for the sheet from Icecat from a provided eloquent product instance, it tries to find the sheet
     * searching by all the icecat_suppliers associated to the product brand (App\Marca), if the sheet exists, this
     * method returns a string object containing the xml, if it not, this method returns false.
     *
     * @param App\Producto $product
     * @param bool|false $save
     * @return string|bool
     */
    private function downloadSheet(App\Producto $product, $save) {
        $endpoint = $this->sheet_endpoint;
        $numero_parte = preg_replace('/\s/', '%', $product->numero_parte);
        $endpoint = str_replace('{numero_parte}', $numero_parte, $endpoint);

        $suppliers = $product->marca->icecatSuppliers;

        foreach ($suppliers as $supplier) {
            $xml = $this->sheetIsValid(str_replace('{marca}', $supplier->name, $endpoint), $numero_parte, $save);
            if (!empty($xml)) {
                break;
            }
        }

        return empty($xml) ? false : $xml;
    }

    /**
     * This method downloads a product sheet from Icecat (spanish) using product part number (icecat prod id)
     * and icecat supplier name, if save flag is TRUE, it saves its contents to a file
     *
     * @param $part_number
     * @param $brand
     * @param bool|false $save
     * @return bool
     */
    public function downloadSheetRaw($part_number, $brand, $save = false) {
        $endpoint = $this->sheet_endpoint;
        $part_number = preg_replace('/\s/', '%', $part_number);
        $endpoint = str_replace('{numero_parte}', $part_number, $endpoint);
        $endpoint = str_replace('{marca}', $brand, $endpoint);

        return $this->sheetIsValid($endpoint, $part_number, $save);
    }

    /**
     * This method gets a sheet from Icecat and search for error messages, if errors were found
     * this method returns false, otherwise returns the xml
     * @param $endpoint
     * @param $part_number
     * @param $save
     * @return bool|string
     */
    private function sheetIsValid($endpoint, $part_number, $save) {
        $file = file_get_contents($endpoint);
        $simple_xml = simplexml_load_string($file);
        if (empty((string) $simple_xml->Product[0]->attributes()['ErrorMessage'])) {
            $xml = $file;
            if ($save) {
                file_put_contents('Icecat/' . $part_number . '.xml', $file);
            }
        }

        return isset($xml) ? $xml : false;
    }

    /**
     * This method transforms a previous parsed product sheet from icecat and turns it into
     * a pretty associative array.
     * @param array $sheet
     * @return array
     */
    private function prettySheet(array $sheet) {
        $icecat_category = App\IcecatCategory::whereIcecatId($sheet['icecat_category_id'])->first();
        $producto = [
            'subfamilia_id'      => $icecat_category ? $icecat_category->subfamilia_id : '',
            'descripcion'        => $sheet['long_summary_description'],
            'descripcion_corta'  => $sheet['short_summary_description']
        ];
        $ficha = [
            'calidad' => $sheet['quality'],
            'titulo'  => $sheet['title']
        ];
        $caracteristicas = array_map(function ($feature) use ($sheet) {
            $icecat_category_feature = App\IcecatCategoryFeature
                ::whereIcecatFeatureId($feature['icecat_feature_id'])
                ->whereIcecatCategoryId($sheet['icecat_category_id'])
                ->whereIcecatCategoryFeatureGroupId($feature['icecat_category_feature_group_id'])->first();
            if (!empty($icecat_category_feature)) {
                return [
                    'icecat_category_feature_id' => $icecat_category_feature->id,
                    'valor'                      => $feature['value'],
                    'valor_presentacion'         => $feature['presentation_value']
                ];
            }
        }, $sheet['features']);
        return compact('producto', 'ficha', 'caracteristicas');
    }

    /**
     * ************************************ PARSE METHODS ************************************************
     */

    /**
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $category_node
     * @param boolean $with_parent
     * @return array
     */
    private function parseCategoryNode(\SimpleXMLElement $category_node, $with_parent = false) {
        $icecat_id = (int) $category_node->attributes()['ID'];

        if (!empty($name = $this->getLangValue($category_node->Name))) {
            $description = $this->getLangValue($category_node->Description);
            $keyword = $this->getLangValue($category_node->Keywords);
            if ($with_parent) {
                $icecat_parent_category_id = (int) $category_node->ParentCategory->attributes()['ID'];
            } else {
                $icecat_parent_category_id = null;
            }

            return compact('icecat_id', 'description', 'keyword', 'name', 'icecat_parent_category_id');
        } else {
            return null;
        }
    }

    /**
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $supplier_node
     * @return array
     */
    private function parseSupplierNode(\SimpleXMLElement $supplier_node) {
        $icecat_id = (int) $supplier_node->attributes()['ID'];
        if (!empty($name = (string) $supplier_node->attributes()['Name'])) {
            $logo_url = $supplier_node->attributes()['LogoPic'] ? (string) $supplier_node->attributes()['LogoPic'] : '';

            return compact('icecat_id', 'name', 'logo_url');
        } else {
            return null;
        }
    }

    /**
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $feature_node
     * @return array
     */
    private function parseFeatureNode(\SimpleXMLElement $feature_node) {
        $icecat_id = (int) $feature_node->attributes()['ID'];

        if (!empty($name = $this->getLangText($feature_node->Names->Name))) {
            $type = (string) $feature_node->attributes()['Type'];
            $description = $this->getLangValue($feature_node->Descriptions);
            $measure = $feature_node->Measure ? (string) $feature_node->Measure->attributes()['Sign'] : '';

            return compact('icecat_id', 'type', 'name', 'description', 'measure');
        } else {
            return null;
        }
    }


    /**
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $category_node
     * @return array
     */
    private function parseCategoryFeatureGroupNode(\SimpleXMLElement $category_node) {
        $icecat_category_id = (int) $category_node->attributes()['ID'];
        $category_feature_groups = [];
        foreach ($category_node->CategoryFeatureGroup as $category_feature_group_node) {
            if (!empty($category_feature_group_node->FeatureGroup)) {
                array_push($category_feature_groups, [
                    'icecat_id'               => (int) $category_feature_group_node->attributes()['ID'],
                    'icecat_category_id'      => $icecat_category_id,
                    'icecat_feature_group_id' => (int) $category_feature_group_node->FeatureGroup->attributes()['ID']
                ]);
            }
        }

        return count($category_feature_groups) > 0 ? $category_feature_groups : null;
    }

    /**
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $category_node
     * @return array
     */
    private function parseCategoryFeatureNode(\SimpleXMLElement $category_node) {
        $icecat_category_id = (int) $category_node->attributes()['ID'];
        $categories_features = [];

        foreach ($category_node->Feature as $feature_node) {
            array_push($categories_features, [
                'icecat_id'                        => (int) $feature_node->attributes()['CategoryFeature_ID'],
                'icecat_category_id'               => $icecat_category_id,
                'icecat_feature_id'                => (int) $feature_node->attributes()['ID'],
                'icecat_category_feature_group_id' => (int) $feature_node->attributes()['CategoryFeatureGroup_ID']
            ]);
        }

        return count($categories_features) > 0 ? $categories_features : null;
    }

    /**
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $category_node
     * @param array $categories_feature_groups
     * @return array
     */
    private function parseFeatureGroupFeatureNode(\SimpleXMLElement $category_node, $categories_feature_groups) {
        $feature_group_feature = [];

        foreach ($category_node->Feature as $feature_node) {
            $categories_feature_group_id = (int) $feature_node->attributes()['CategoryFeatureGroup_ID'];
            array_push($feature_group_feature, [
                'icecat_feature_group_id' => $categories_feature_groups[$categories_feature_group_id]['icecat_feature_group_id'],
                'icecat_feature_id'       => (int) $feature_node->attributes()['ID'],
            ]);
        }

        return count($feature_group_feature) > 0 ? $feature_group_feature : null;
    }

    /**
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $group_node
     * @return array
     */
    private function parseFeatureGroupNode(\SimpleXMLElement $group_node) {
        $icecat_id = (int) $group_node->attributes()['ID'];

        if (!empty($name = $this->getLangValue($group_node->Name))) {

            return compact('icecat_id', 'name');
        } else {
            return null;
        }
    }


    /**
     * *************************************** HELPERS ***************************************************
     */

    /**
     * Iterates over each one of the values for one field, and returns the value attribute of the one which
     * has the desired lang_id, by default this is equals to 6 (Spanish for Icecat)
     * @param array $field_array
     * @param string $lang_id
     * @return string
     */
    private function getLangValue($field_array, $lang_id = '6') {
        $field_value = '';
        foreach ($field_array as $element) {
            if ($element->attributes()['langid'] == $lang_id) {
                $field_value = $element->attributes()['Value'];
                break;
            }
        }

        return (string) $field_value;
    }

    /**
     * Iterates over each one of the values for one field, and returns the text of which
     * has the desired lang_id, by default this is equals to 6 (Spanish for Icecat)
     * @param array $field_array
     * @param string $lang_id
     * @return string
     */
    private function getLangText($field_array, $lang_id = '6') {
        $field_text = '';
        if (count($field_array) > 0) {
            foreach ($field_array as $element) {
                $found_lang_id = $element->attributes()['langid'];
                if ($found_lang_id == $lang_id || $found_lang_id == '1') {
                    $field_text = (string) $element;
                    break;
                }
            }
        }

        return $field_text;
    }

    /**
     * This method performs a download using CURL for CategoriesFeatures, because Icecat XML file size is too big
     * for normal file_get_contents, also XML must be decoded in chunks instead.
     */
    private function downloadAndDecodeCategoriesFeatures() {
        curlDownload($this->refs_endpoint . $this->refs['category_features'], 'Icecat/categories_features.xml.gz');
        $file_name = 'Icecat/categories_features.xml.gz';
        $buffer_size = 4096;
        $out_file_name = str_replace('.gz', '', $file_name);
        $file = gzopen($file_name, 'rb');
        $out_file = fopen($out_file_name, 'wb');
        while (!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }
        fclose($out_file);
        gzclose($file);
    }

    /**
     * This method performs a download using CURL for Features, because Icecat XML file size is too big
     * for normal file_get_contents, also XML must be decoded in chunks instead.
     */
    private function downloadAndDecodeFeatures(){
        curlDownload($this->refs_endpoint . $this->refs['features'], 'Icecat/features.xml.gz');
        $file_name = 'Icecat/features.xml.gz';
        $buffer_size = 4096;
        $out_file_name = str_replace('.gz', '', $file_name);
        $file = gzopen($file_name, 'rb');
        $out_file = fopen($out_file_name, 'wb');
        while (!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }
        fclose($out_file);
        gzclose($file);
    }

    /**
     * This method receives the XML as string and returns the relevant data as an associative array
     * @param string $xml
     * @return array
     */
    private function parseProductSheet($xml) {
        $xml = simplexml_load_string($xml);
        $product = $xml->Product;

        // Quality
        $quality = (string) $product->attributes()['Quality'];

        // Product Information
        $icecat_product_id = (int) $product->attributes()['ID'];
        $high_pic_url = (string) $product->attributes()['HighPic'];
        $low_pic_url = (string) $product->attributes()['LowPic'];
        $thumb_pic_url = (string) $product->attributes()['ThumbPic'];
        $title = (string) $product->attributes()['Title'];

        // Category
        $icecat_category_id = (int) $product->Category->attributes()['ID'];

        // Product Features
        $features = [];
        $product_features = $product->ProductFeature;
        foreach ($product_features as $product_feature) {
            $value = (string) $product_feature->attributes()['Value'];
            $presentation_value = (string) $product_feature->attributes()['Presentation_Value'];
            $icecat_feature_id = (int) $product_feature->Feature->attributes()['ID'];
            $icecat_category_feature_group_id = (int) $product_feature->attributes()['CategoryFeatureGroup_ID'];
            array_push($features, compact('icecat_feature_id', 'icecat_category_feature_group_id', 'icecat_category_id', 'value', 'presentation_value'));
        }

        // Product Supplier
        $icecat_supplier_id = (int) $product->Supplier[0]->attributes()['ID'];

        // Product Gallery
        $gallery = [];
        $gallery_products = $product->ProductGallery;
        if ($gallery_products->count() > 0) {
            foreach ($gallery_products->ProductPicture as $gallery_product) {
                $pic_url = (string) $gallery_product->attributes()['Pic']; // Pic because HighPic is not defined on this chunk
                $low_pic_url = (string) $gallery_product->attributes()['LowPic'];
                $thumb_pic_url = (string) $gallery_product->attributes()['ThumbPic'];
                // In most of the cases, Pic500x500 is empty, so I'm not adding it
                array_push($gallery, compact('pic_url', 'low_pic_url', 'thumb_pic_url'));
            }
        }

        // Summary Description
        $long_summary_description = '';
        $short_summary_description = '';

        if ($product->SummaryDescription->count() > 0) {
            $long_summary_description = (string) $product->SummaryDescription->LongSummaryDescription;
            $short_summary_description = (string) $product->SummaryDescription->ShortSummaryDescription;
        }

        // Related Products
        $related = [];
        $related_products = $product->ProductRelated;
        if ((bool) $product->ProductRelated[0]) {
            foreach ($related_products as $related_product) {
                array_push($related, (int) $related_product->Product->attributes()['ID']);
            }
        }

        return compact('quality', 'icecat_product_id', 'high_pic_url', 'low_pic_url', 'thumb_pic_url',
            'title', 'icecat_category_id', 'icecat_supplier_id', 'long_summary_description', 'short_summary_description', 'features', 'gallery', 'related');
    }
}
