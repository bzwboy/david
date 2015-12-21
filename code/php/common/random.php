<?php
for ($i = 0, $c = 10; $i < $c; $i++) {
    $fp = fopen('/dev/random', 'r');
    xv(bin2hex(fread($fp, 5)));
    fclose($fp);
}

