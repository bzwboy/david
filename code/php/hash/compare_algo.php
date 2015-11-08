<?php
define('testtime', 50000);
$algos = hash_algos();
foreach($algos as $algo) {
    $st = microtime();
    for($i = 0; $i < testtime; $i++) {
        hash($algo, microtime().$i);
    }
    $et = microtime();
    list($ss, $si) = explode(' ', $st);
    list($es, $ei) = explode(' ', $et);
    $time[$algo] = $ei + $es - $si - $ss;
    usleep(100000);
}
asort($time, SORT_NUMERIC);

foreach ($time as $algo => $t) {
    printf('%-10s: %.10f sec', $algo, $t);
    echo "\n";
}
//print_r($time);

