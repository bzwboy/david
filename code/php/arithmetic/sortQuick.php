<?php
#
# 快速排序算法
# 时间复杂度 O(nlogn)
#
function quick($arr)
{
    $n = count($arr);
    if ($n <= 1) {
        return $arr;
    }

    $mid = $arr[0];
    $left = $right = [];
    for ($i = 1; $i < $n; $i++) {
        if ($arr[$i] > $mid) {
            $right[] = $arr[$i];
        } else {
            $left[] = $arr[$i];
        }
    }

    $left = quick($left);
    $right = quick($right);
    return array_merge($left, [ $mid ], $right);
}

$arr = [1,43,54,62,21,66,32,78,36,76,39];
print_r(quick($arr));

