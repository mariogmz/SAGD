<?php

namespace Sagd;


use App;
use ErrorException;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Parser;
use Prewk\XmlStringStreamer\Stream;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

Class Icecat {

    private $username;
    private $password;
    private $refs_endpoint;
    private $refs;

    public function __construct() {
        $this->username = getenv('ICECAT_USERNAME');
        $this->password = getenv('ICECAT_PASSWORD');
        $this->refs_endpoint = "https://{$this->username}:{$this->password}@data.icecat.biz/export/level4/refs";
        $this->refs = [
            'categories'        => 'CategoriesList.xml.gz',
            'category_features' => 'CategoryFeaturesList.xml.gz',
            'features'          => 'FeaturesList.xml.gz',
            'feature_groups'    => 'FeatureGroupList.xml.gz',
            'languages'         => 'LanguageList.xml.gz',
            'measures'          => 'MeasuresLists.xml.gz',
            'relations'         => 'RelationsList.xml',
            'suppliers'         => 'SuppliersList.xml.gz'
        ];
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/CategoriesList.xml.gz" to
     * a PHP associative array.
     * @return array
     */
    public function getCategories() {
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
            $result = $this->parseCategoryNode($category);
            if ($result) {
                array_push($icecat_categories, $result);
            }
        }

//        return $icecat_categories;
        file_put_contents('Icecat/categories.json', json_encode($icecat_categories, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Parse the xml from "https://data.icecat.biz/export/level4/refs/CategoryFeaturesList.xml.gz" to
     * a PHP associative array.
     * @return array
     */
    public function getFeatures() {
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

//        return $icecat_features;
        file_put_contents('Icecat/features.json', json_encode($icecat_features, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    }

    /**
     * Downloads and decodes a requested file from https://data.icecat.biz/export/level4/refs/ , if file
     * was encoded with gzip, this method decodes it and saves the output into a file under the next path:
     *      /Icecat/{$ref_name}.xml
     * If the ref_name is not defined this method will throw an ErrorException
     * @param string $ref_name
     * @throws ErrorException | FileNotFoundException
     */
    private function downloadAndDecode($ref_name) {
        if (isset($this->refs[$ref_name])) {
            $xml = file_get_contents($this->refs_endpoint . $this->refs[$ref_name]);

            if ($xml === false) {
                throw new FileNotFoundException('File ' . $this->refs_endpoint . $this->refs[$ref_name] . ' does not exists.');
            } else {

                if (strpos($ref_name, '.gz') !== - 1) {
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
     * This method takes a simple node and parses its values like [langid=6] (Spanish) and build a more
     * friendly object
     * @param \SimpleXMLElement $category_node
     * @return array
     */
    private function parseCategoryNode(\SimpleXMLElement $category_node) {
        $icecat_id = (int) $category_node->attributes()['ID'];

        if (!empty($name = $this->getLangValue($category_node->Name))) {
            $description = $this->getLangValue($category_node->Description);
            $keyword = $this->getLangValue($category_node->Keywords);
            $parent_category_id = (int) $category_node->ParentCategory->attributes()['ID'];

            return compact('icecat_id', 'description', 'keyword', 'name', 'parent_category_id');
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
     * Iterates over each one of the values for one field, and returns the value attribute of the one which
     * has the desired lang_id, by default this is equals to 6 (Spanish for Icecat)
     * @param Array $field_array
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
     * @param Array $field_array
     * @param string $lang_id
     * @return string
     */
    private function getLangText($field_array, $lang_id = '6') {
        $field_text = '';
        if (count($field_array)>0) {
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
