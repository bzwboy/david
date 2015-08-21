<?php
#
# 合并（归并）排序算法
# 时间复杂度 O(nlogn)
#
class MergeSort2
{
    private function _merge($arr1, $arr2)
    {
        $arr3 = array();
        while(!empty($arr1) && !empty($arr2)){
            // 比较第一个元素，取较小的值
            $arr3[] = $arr1[0] <= $arr2[0] ? array_shift($arr1) : array_shift($arr2);
        }
        // 剩下的$arr1和$arr2中都是较大的值，且他们是有序的，故可以直接合并到$arr3后面
        return array_merge($arr3, $arr1, $arr2);
    }

    // 归并排序算法
    public function msort($arr)
    {
        if(count($arr) <= 1) return $arr;
    
        // 将大数组拆分为两个数组
        $mid = intval(count($arr)/2);
        $arr1 = array_slice($arr, 0, $mid);
        $arr2 = array_slice($arr, $mid);

        // 利用递归思想，不断拆分数组，再逐步merge回来
        return $this->_merge($this->msort($arr1), $this->msort($arr2));
    }
}

$arr = [1,43,54,62,21,66,32,78,36,76,39];
$ms2 = new MergeSort2;
print_r($ms2->msort($arr));

