<?php
#
# 把10个数据分布到3个桶中
# 主要是用于大集合分成小集合
#

$num = range(1,10);
shuffle($num);
$bucket = 3;
echo "raw data list: \n";
print_r($num);

$set = [];
foreach ($num as $n) {
    $set[$n % $bucket][] = $n;
}

echo "\nBucket $bucket: \n";
print_r($set);

