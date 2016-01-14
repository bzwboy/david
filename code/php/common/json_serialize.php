<?php
// 测试 json/serialize 性能

$data = array();
for ($i = 0, $c = 500; $i < $c; $i++) {
    $sub = array();
    for ($j = 0, $n = 500; $j < $n; $j++) {
        $sub[] = $j;
    }
    $data[] = $sub;
}

echo "==> 测试 json 性能<==\n";
$t = microtime(true);
$json = json_encode($data);
json_decode($json, true);
echo "time:", (microtime(true)-$t), "\n";
xd(strlen($json));
unset($json);
echo "\n";

sleep(1);

echo "==> 测试 serialize 性能<==\n";
$t = microtime(true);
$seri = serialize($data);
unserialize($seri);
echo "time:", (microtime(true)-$t), "\n";
xd(strlen($seri));
unset($seri);

