<?php
#
# 冒泡排序
#
function bubble_1($arr) {
    $n = count($arr);
    for($i=0;$i<$n-1;$i++){
        for($j=$i+1;$j<$n;$j++) {
            if($arr[$j]<$arr[$i]) {
                $temp=$arr[$i];
                $arr[$i]=$arr[$j];
                $arr[$j]=$temp;
            }
        }
    }
    return $arr;
}

#
# 冒泡排序算法二
#
function bubble_2($arr)
{
    $len = count($arr);
    for ($i = 1; $i < $len; $i++) {
        for ($j = 0; $j < $len - $i; $j++) {
            if ($arr[$j] > $arr[$j+1]) {
                $tmp = $arr[$j];
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $tmp;
            }
        }
    }

    return $arr;
}

$arr = [1,43,54,62,21,66,32,78,36,76,39];
print_r(bubble_1($arr));
print_r(bubble_2($arr));

