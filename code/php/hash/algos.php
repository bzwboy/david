<?php
$hash_list = hash_algos();

$sort = $val = array();
foreach ($hash_list as $algo) {
    $hash = hash($algo, microtime());
    $len = strlen($hash);

    $sort[$algo] = strlen($hash);
    $val[$algo] = $hash;
}

asort($sort, SORT_NUMERIC);
foreach ($sort as $_algo => $len) {
    printf("[%10s], len: %3d, val: %s", $_algo, $len, $val[$_algo]);
    echo "\n";
}

