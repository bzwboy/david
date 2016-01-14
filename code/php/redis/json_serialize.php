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
$redis = new Redis;
$redis->connect('localhost', 6379);
$redis->set('str', $json);
json_decode($redis->get('str'), true);
echo "time:", (microtime(true)-$t), "\n";
xd(strlen($json));
unset($json, $redis);
echo "\n";

sleep(1);

echo "==> 测试 serialize 性能<==\n";
$t = microtime(true);
$redis = new Redis;
$redis->connect('localhost', 6379);
$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
$redis->set('str', $data);
$ret = $redis->get('str');
echo "time:", (microtime(true)-$t), "\n";

$redis = new Redis;
$redis->connect('localhost', 6379);
$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
$redis->set('str', $data);
$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_NONE);
xd(strlen($redis->get('str')));

