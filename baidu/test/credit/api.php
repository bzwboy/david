#!/home/users/libo38/odp/php/bin/php
<?php
 
Bd_Init::init('memberapi');

$umoney = Bd_Conf::getAppConf('/credit/umoney');
$arrData = array(
    'channel' => 'NUOMI01',
    'logintype' => 'AND001',
    'method' => 'precredit',
    'methoddata' => array(
        'passid' => '1744234503',
        'sign_method' => 1,
        'sign' => '',
    ),
);
$umoney = Bd_Conf::getAppConf('/credit/umoney');
$strSign = 'passid=' . $arrData['methoddata']['passid'] . '&sign_method=' . $arrData['methoddata']['sign_method'] . '&key='.$umoney['key'];
$arrData['methoddata']['sign'] = md5($strSign);
ral_set_pathinfo('/umoney/user');
$strRet = ral('creditUmoney', 'post', 'data='. json_encode($arrData), rand());
var_dump($strRet);



