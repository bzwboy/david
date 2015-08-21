<?php
#
# 求任意区间素数（质数）
# 质数（prime number）又称素数，有无限个。一个大于1的自然数，除了1和它本身外，
# 不能被其他自然数（质数）整除，换句话说就是该数除了1和它本身以外不再有其他的因数；否则称为合数。
#
# 时间复杂度 O(n^2)
function sushu($s, $e)
{
    for ($i = $s; $i < $e; $i++) {
        $primer = 0;
        for ($j = 1; $j <= $i; $j++) {
            if ($i%$j === 0){ ++$primer; }
        }
        if ($primer < 3) echo $i, "\n";
    }
}
sushu(1, 100);

