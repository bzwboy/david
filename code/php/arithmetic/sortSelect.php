<?php
#
# 选择排序算法
#
function xuanze($arr)
{
    $len = count($arr);
    for ($i = 0; $i < $len - 1; $i++) {
        $p = $i;
        for ($j = $i + 1; $j < $len; $j++) {
            if ($arr[$p] > $arr[$j]) {
                $p = $j;
            }
        }

        if ($p != $i) {
            $tmp = $arr[$i];
            $arr[$i] = $arr[$p];
            $arr[$p] = $tmp;
        }
    }

    return $arr;
}

$arr = [1,43,54,62,21,66,32,78,36,76,39];
print_r(xuanze($arr));

