<?php
#
# 希尔排序算法
# 时间复杂度 O((nlogn)^2)
#
# 原理：
# 希尔排序也称之为递减增量排序，他是对插入排序的改进。希尔排序通过将待比较的元素划分为几个区域来提升插入排序的效率。这样可以让元素可以一次性的朝最终位置迈进一大步，然后算法再取越来越小的步长进行排序，最后一步就是步长为1的普通的插入排序的，但是这个时候，整个序列已经是近似排好序的，所以效率高。
#
# @see http://www.cnblogs.com/yangecnu/p/Introduction-Insertion-and-Selection-and-Shell-Sort.html
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
            #echo '$i=', $i, "\n";
            #echo '$h=', $h, "\n";
            for ($j = $i; $j >= $h; $j = $j - $h) {
                #echo '$j=', $j, "\n";
                if ($arr[$j] < $arr[$j - $h]) {
                    swap($arr, $j, $j - $h);
                } else {
                    break;
                }
            }
        }

        #echo '-------------', "\n";
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

