<?php
set_time_limit(0);

$log = '/home/users/libo38/tmp/mkapi-log';
$fp = fopen($log, 'r');
$ret = array();
while (!feof($fp)) {
    $str = fgets($fp, 10240);
    preg_match('/NOTICE: (.*) (.*) \[/isU', $str, $arr);
    #var_dump($arr);
    #exit;
    #if (0 !== strpos($arr[7], '17')) {
    #    print_r($arr[7]);
    #    echo $str;
    #    exit;
    #}

    if (!isset($ret[$arr[2]])) {
        $ret[$arr[2]] = 1;
    } else {
        ++$ret[$arr[2]];
    }
}
arsort($ret);
print_r(array_slice($ret, 0, 10));
#ksort($ret);
#print_r($ret);

