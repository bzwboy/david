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

$userId = 1;
$userId = 556869752; // teacher
$userId = 33896531; // me

// local
#$hostname = 'cp01-rdqa-dev384.cp01.baidu.com';
#$url = "http://${hostname}:8081/memberapi/points/add";
#$url = "http://${hostname}:8081/memberapi/commit/addpointsnmq";


// 预览机
#$hostname = 'nj02-orp-app1487.nj02.baidu.com';
#$url = "http://${hostname}:8220/memberapi/points/add";
#$url = "http://${hostname}:8220/memberapi/commit/addpointsnmq";


// online
$hostname = 'memberapi.int.nuomi.com';
$url = "http://${hostname}/memberapi/points/add";

$appId = 115;
$token = Bd_Conf::getAppConf("/common/points/src/${appId}/token");//'f4f6ca2910ce285169d50f95ff3c3e23';
$time = time();
$pointsSrc = Bd_Conf::getAppConf("/common/points/src/${appId}/db_points_src");
$pointsValue = 1;
$uniqId = md5($appId . $pointsSrc . $userId . microtime(true) . mt_rand());

/*
$postData = array(
    'data' => json_encode(array(
    'appId' => '115',
    'verChannel' => 'nuomi',
    'intToken' => '',
    'intTimestamp' => $time,
    'baiduId' => '',
    'userId' => $userId,
    'srcUniqid' => $uniqId,
    'pointsValue' => $pointsValue,
    'pointsCtime' => $time,
    'pointsSrc' => '61',
    'machine' => $hostname,
    'phone' => '15811261604',
)));
 */

$postData = array(
    'appId' => '115',
    'verChannel' => 'nuomi',
    'intToken' => '',
    'intTimestamp' => $time,
    'baiduId' => '',
    'userId' => $userId,
    'srcUniqid' => $uniqId,
    'pointsValue' => $pointsValue,
    'pointsCtime' => $time,
    'pointsSrc' => '61',
    'machine' => $hostname,
    'phone' => '15811261604',
);
function getIntToken($params, $token) {                                          
    ksort ( $params, SORT_STRING ); // 对参数的key以字母顺序排序                         
    $paramsArr = array ();                                                               
    foreach ( $params as $pkey => $pval ) {                                              
        if ($pkey == "intToken" || $pkey == "log_id") {                                  
            continue;                                                                    
        }                                                                                
        array_push ( $paramsArr, ($pkey . ":" . $pval) ); // 用冒号连结参数的key和val    
    }                                                                                    
    $hashString = implode ( "_", $paramsArr ); // 用下划线连结各参数(key,val)对          
    $hashString = $hashString . "_" . $token; // 在最后加上有效的token                   
    $intToken = sha1 ( $hashString );                                                    
    return $intToken;                                                                    
}  
$intToken = getIntToken($postData, $token);
$postData['intToken'] = $intToken;

// 重入测试
#$postData['intToken'] = '7c27061fe374dba61b9256204eeee7e29e8a7ce1';
#$postData['intTimestamp'] = '1447237022';
#$postData['pointsCtime'] = '1447237022';
#$postData['srcUniqid'] = '610e8f1ecbd363dbfb44250e6495dae0';




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
