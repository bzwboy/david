<?php
#
# n的阶乘
# 0,1,2,3,4
#

function Factorial($n)
{
    if ($n <= 1) {
        return 1;
    } else {
        return $n * Factorial($n-1);
    }
}

echo 'Factorial Sum: ', Factorial(3);

