#!/home/users/libo38/odp/php/bin/php
<?php
/***************************************************************************
 * 
 * Copyright (c) 2015 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file redis.php
 * @author libo38(com@baidu.com)
 * @date 2015/11/17 13:35:01
 * @brief 
 *  
 **/

include getcwd() . '/config.php';
Bd_Init::init('memberapi');

Bd_Log::warning('libo');

$conf = Bd_Conf::getAppConf('/common/redis/credit_limit_value');
$rKey = $conf['KPRE'] . $userId;
#echo $rKey;

$redis = new Redis();
$redis->connect('localhost', 6379);
var_dump($redis->get($rKey));





/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
