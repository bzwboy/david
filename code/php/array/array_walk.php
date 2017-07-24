<?php
$arr = [
    'a' => 1,
    'b' => 2,
];
$param = 'params';

// 通过第三个参数实现参数传入
echo "通过第三个参数实现参数传入\n";
array_walk($arr, function($v, $k, $data) {
    var_dump("$k => $v");
    $data = 'modify';
}, $param);
var_dump($param);
echo "\n";

// &引用不起作用
echo "&引用不起作用\n";
array_walk($arr, function($v, $k, &$data) {
    $data = 'modify';
    var_dump($data); // modify
}, $param);
var_dump($param); // params
echo "\n";

// 可以在数组中利用引用修改传入的值
echo "可以在数组中利用引用修改传入的值\n";
array_walk($arr, function($v, $k) use (&$param) {
    $param = 'modify';
    var_dump($param); // modify
}, $param);
var_dump($param); // modify
