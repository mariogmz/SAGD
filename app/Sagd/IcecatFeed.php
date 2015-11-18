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
    }

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
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/CategoryFeaturesList.xml.gz" to
     * a PHP associative array and then saves it to a .json file
     * @param bool $get_array
     * @return int
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
     * @return int
     */
    public function getFeatureGroups() {
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

        return file_put_contents('Icecat/feature_groups.json', json_encode($icecat_feature_groups, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/SuppliersList.xml.gz" to
     * a PHP associative array and then saves it to a .json file
     * @param bool $get_array
     * @return int
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
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/FeatureGroupList.xml.gz" to
     * a PHP associative array and then saves it to a .json file
     * @return int
     */
    public function getCategoryFeature() {
        $stream = new Stream\File('Icecat/category_features.xml', 1024);
        $parser = new Parser\StringWalker([
            'captureDepth' => 4
        ]);

        $streamer = new XmlStringStreamer($parser, $stream);

        while ($node = $streamer->getNode()) {
            $relation = simplexml_load_string($node);
            $result = $this->parseCategoryFeatureNode($relation);
            if ($result) {
                array_push($icecat_feature_groups, $result);
            }
        }

        return file_put_contents('Icecat/feaure_groups.json', json_encode($icecat_feature_groups, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

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
     * @param \SimpleXMLElement $feature_node
     * @return array
     */
    private function parseFeatureNode(\SimpleXMLElement $feature_node) {
        $icecat_id = (int) $feature_node->attributes()['ID'];

        if (!empty($name = $this->getLangText($feature_node->Names->Name))) {
            $type = (string) $feature_node->attributes()['Type'] ?: 'null';
            $description = $this->getLangValue($feature_node->Descriptions) ?: 'null';
            $measure = $feature_node->Measure ? (string) $feature_node->Measure->attributes()['Sign'] : '';

            return compact('icecat_id', 'type', 'name', 'description', 'measure');
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
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $category_feature_node
     * @return array
     */
    private function parseCategoryFeatureNode(\SimpleXMLElement $category_feature_node) {
        $category_id = (int) $category_feature_node->attributes()['ID'];
        $category_feature_group_ids = [];
        $feature_ids = [];
        foreach ($category_feature_node->CategoryFeatureGroup as $category_feature_group) {
            array_push($category_feature_group_ids, (int) $category_feature_group->attributes()['ID']);
        }
        foreach ($category_feature_node->Feature as $feature) {
            array_push($feature_ids, (int) $feature->attributes()['ID']);
        }
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

        } else {
            throw new ErrorException("Unknown Icecat reference file, not found on index: {$ref_name}.");
        }
    }

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
}
