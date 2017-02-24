<?php
#
# 二分法查找
# 时间复杂度 O(logn)
# 空间复杂度 O(1)
#
function bin_search($arr, $low, $high, $value) 
{
    if($low > $high) {
        return false;
    } else {
        $mid = floor(($low+$high)/2);
        if ($value == $arr[$mid]) {
            return $mid;
        } elseif ($value < $arr[$mid]) {
            return bin_search($arr, $low, $mid - 1, $value);
        } else {
            return bin_search($arr, $mid + 1, $high, $value);
        }
    }
}

$arr = [2,1,3,5,4];
print_r($arr);
print_r(bin_search($arr, 1, 5, 3));

