<?php
#
# 选择排序算法
# 时间复杂度 O(n^2)
#
# 原理：
# 1、从左至右遍历，找到最小(大)的元素，然后与第一个元素交换。
# 2、从剩余未排序元素中继续寻找最小（大）元素，然后与第二个元素进行交换。
# 3、以此类推，直到所有元素均排序完毕。
#
function xuanze($arr)
{
    $n = count($arr);
    for ($i = 0; $i < $n - 1; $i++) {
        $p = $i;
        for ($j = $i + 1; $j < $n; $j++) {
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

