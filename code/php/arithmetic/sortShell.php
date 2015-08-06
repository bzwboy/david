<?php
#
# 希尔排序算法
#
function shell($arr)
{
    $n = count($arr);
    $h = 1;
    while ($h < $n / 3) { 
        $h = $h * 3 + 1;
    }

    while ($h >= 1) {
        for ($i = 1; $i < $n; $i++) {
            for ($j = $i; $j >= $h; $j = $j - $h) {
                if ($arr[$j] < $arr[$j - $h]) {
                    swap($arr, $j, $j - $h);
                } else {
                    break;
                }
            }
        }

        $h = floor($h / 3);
    }

    return $arr;
}

function swap(&$arr, $i, $j)
{
    $tmp = $arr[$i];
    $arr[$i] = $arr[$j];
    $arr[$j] = $tmp;
}

$arr = [1,43,54,62,21,66,32,78,36,76,39];
print_r(shell($arr));

