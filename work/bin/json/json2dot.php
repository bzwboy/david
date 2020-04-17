#!/usr/local/bin/php
<?php

// ./% <file>

if (empty($argv)) {
    echo <<<H
    ./json2dot.php <dir/file>
H;
    exit(1);
}

$file = $argv[1];

$json_arr = json_decode(file_get_contents($file), 1);

$result = array();
$iter = new RecursiveIteratorIterator(new RecursiveArrayIterator($json_arr));
foreach ($iter as $leafValue) {
    $keys = array();
    foreach (range(0, $iter->getDepth()) as $depth) {
        $keys[] = $iter->getSubIterator($depth)->key();
    }
    $result[ join('.', $keys) ] = $leafValue;
}

foreach ($result as $k => $v) {
    $type = ucfirst(gettype($v));

    switch ($type) {
    case 'Integer':
        $type = 'Int';
        break;
    }

    echo "${k}\t${type}\t${v}" . PHP_EOL;
}
