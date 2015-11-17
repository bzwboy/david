#!/home/users/libo38/odp/php/bin/php
<?php
Bd_Init::init('memberapi');

include getcwd() . '/config.php';

$postData = array(
    'pass_uid' => $userId,
    'terminal' => $terminal,
);

// 本机 online 环境测试
// http://cp01-rdqa-dev384.cp01.baidu.com:8080/memberapi/privilege/creditstatus
$url = "http://${hostname}:8080/memberapi/privilege/creditstatus";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
$ret = curl_exec($ch);
if(!$ret) {
    echo 'Curl error: ' . curl_error($ch) . PHP_EOL;
    echo 'Curl error number: ' . curl_errno($ch);
} else {
    echo '操作完成', PHP_EOL;
}
curl_close($ch);


/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
