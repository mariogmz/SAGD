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
