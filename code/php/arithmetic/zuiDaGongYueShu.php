<?php
#
# 最大公约数
# 欧几里得算法, Gcd(m, n)
#
$m = 16;
$n = 8;

function gcd($m, $n) {
    while ($n > 0) {
        $rem = $m % $n;
        $m = $n;
        $n = $rem;
        #echo $n, "\n";
    }

    return $m;
}

echo 'result: ', gcd($m, $n), "\n";

