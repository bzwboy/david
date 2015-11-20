<?php
/***************************************************************************
 * 
 * Copyright (c) 2015 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file testAdd.php
 * @author libo38(com@baidu.com)
 * @date 2015/11/10 12:01:54
 * @brief 
 *  
 **/
Bd_Init::init('memberapi');

$appId = 115;
$time = time();
$userId = 1;
$hostname = 'cp01-rdqa-dev384.cp01.baidu.com';

$postData = array(
    'appId' => '115',
    'verChannel' => 'nuomi',
    'intToken' => '',
    'intTimestamp' => $time,
    'baiduId' => '',
    'pass_uid' => $userId,
    'start' => 0,
    'offset' => 2,
    'terminal' => 'ios',
);

// 重入测试
#$postData['intToken'] = '7c27061fe374dba61b9256204eeee7e29e8a7ce1';
#$postData['intTimestamp'] = '1447237022';
#$postData['pointsCtime'] = '1447237022';
#$postData['srcUniqid'] = '610e8f1ecbd363dbfb44250e6495dae0';

// 本机 online 环境测试
// http://cp01-rdqa-dev384.cp01.baidu.com:8080/memberapi/points/add
$url = "http://${hostname}:8081/memberapi/points/detail";
// mktapi 营销api
#$url = "http://cp01-rdqa04-dev170.cp01.baidu.com:8281/mktapi/redirect/memberapi/points/add";
// 本机 work 环境测试
#$url = "http://${hostname}:8081/memberapi/points/add";
// work-nmq 后端路径
#$url = "http://${hostname}:8081/memberapi/commit/addpointsnmq";
#$postData['data'] = json_encode($postData);

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
