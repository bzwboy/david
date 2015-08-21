<?php
#
# 插入排序算法
# 时间复杂度 O(n^2)
#
# 原理：
# 1、从第一个元素开始，该元素可以认为已经被排序
# 2、取出下一个元素，在已经排序的元素序列中从后向前扫描
# 3、如果该元素小于前面的元素（已排序），则依次与前面元素进行比较如果小于则交换，直到找到大于该元素的就则停止；
# 4、如果该元素大于前面的元素（已排序），则重复步骤2
# 5、重复步骤2~4 直到所有元素都排好序。
#
function insert($arr)
{
    $n = count($arr);
    for ($i = 1; $i < $n; $i++) {
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

