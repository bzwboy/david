<?php
#
# 测试生成数组
# 使用内存最少的方案
#

#
# Current PHP version: 5.5.18
# method 1: 传统的for循环
# 分配给 PHP 内存的峰值 : 29525792
# 分配给 PHP 的内存量   : 29523448
# 系统分配的真实内存尺寸: 29884416
# ==========================
# Current PHP version: 5.5.18
# method 2: php 函数
# 分配给 PHP 内存的峰值 : 29525304
# 分配给 PHP 的内存量   : 225464
# 系统分配的真实内存尺寸: 524288
# ==========================
# Current PHP version: 5.5.18
# method 3: 语法生成器
# 分配给 PHP 内存的峰值 : 29528864
# 分配给 PHP 的内存量   : 29525648
# 系统分配的真实内存尺寸: 29884416
# ==========================
#

$max = 200000;
echo 'Current PHP version: ' . phpversion(). PHP_EOL;

// method 1: 传统的for循环
#echo "method 1: 传统的for循环\n";
#for($i = 0; $i < $max; $i++) {
#  $arr[$i] = $i;
#}

// method 2: php 函数
#echo "method 2: php 函数\n";
#range(0, $max);

// method 3: 语法生成器
#echo "method 3: 语法生成器\n";
#function xrange($start, $end) {
#    for ($i = $start; $i <= $end; $i++) {
#        yield $i;
#    }
#}
#foreach (xrange(1, $max) as $i) {
#    $arr[$i] = $i;
#}

echo sprintf("%-30s: %d\n", "分配给 PHP 内存的峰值", memory_get_peak_usage());
echo sprintf("%-29s: %d\n", "分配给 PHP 的内存量", memory_get_usage());
echo sprintf("%-33s: %d\n", "系统分配的真实内存尺寸", memory_get_usage(true));
echo "==========================\n";

// 传统的for循环: 9789696字节(峰值) 6639888字节
// 语法糖迭代器:  9795176字节(峰值) 6640952字节
