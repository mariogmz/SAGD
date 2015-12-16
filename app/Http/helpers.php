<?php

function debug($var) {
    print_r("\n");
    var_dump($var);
    print_r("\n");
}

/**
 * Reindexa un array usando el valor de uno de sus campos
 * @param String $key
 * @param array $result_set
 */
function reindexar($key, &$result_set) {
    $reindexed = array_map(function ($element) {
        return (array) $element;
    }, $result_set);
    $result_set = array_column($reindexed, null, $key);
}

if (!function_exists('gzdecode')) {
    /**
     * Decode gz coded data
     *
     * http://php.net/manual/en/function.gzdecode.php
     *
     * Alternative: http://digitalpbk.com/php/file_get_contents-garbled-gzip-encoding-website-scraping
     *
     * @param string $data gzencoded data
     * @return string inflated data
     */
    function gzdecode($data) {
        // strip header and footer and inflate

        return gzinflate(substr($data, 10, - 8));
    }
}

function recursive_array_search($needle, $haystack) {
    foreach ($haystack as $key => $value) {
        $current_key = $key;
        if ($needle === $value OR (is_array($value) && recursive_array_search($needle, $value) !== false)) {
            return $current_key;
        }
    }

    return false;
}

function curlDownload($sourceURL, $outputfilePath) {
    $fp = fopen($outputfilePath, 'w');
    $options = [
        CURLOPT_FILE           => $fp,
        CURLOPT_TIMEOUT        => 2880,
        CURLOPT_URL            => $sourceURL,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $contents = curl_exec($ch);
    curl_close($ch);
    fclose($fp);;
    return $contents;
}
