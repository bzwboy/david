<?php
#
# 插入排序算法
#
function insert($arr)
{
    $len = count($arr);
    for ($i = 1; $i < $len; $i++) {
        $tmp = $arr[$i];
        for ($j = $i-1; $j > 0; $j--) {
            if ($arr[$j] > $tmp) {
                $arr[$j+1] = $arr[$j];
                $arr[$j] = $tmp;
            } else {
                break;
            }
        }
    }

    return $arr;
}

$arr = [1,43,54,62,21,66,32,78,36,76,39];
print_r(insert($arr));

