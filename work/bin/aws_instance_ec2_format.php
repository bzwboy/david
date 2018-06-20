#!/usr/bin/env php
<?php
$fp = fopen('php://stdin', 'r');

$json = '';
while(!feof($fp)){
    $json .= fgets($fp, 4096);
}
fclose($fp);

$arr = json_decode($json);
if (empty($arr)) {
    echo "-Err, empty data\n";
    die;
}

$result = [];
foreach ($arr as $items) {
    foreach ($items as $it) {
        $result[] = implode(' ', $it);
    }
}

echo implode("\n", $result);

