<?php
/**
 * 加密/解密函数
 */

$cipher = MCRYPT_RIJNDAEL_128;
$mode = MCRYPT_MODE_CBC;

$data = '15811261604';
#$data = '010-55341234';

$key = 1234556789012345567890;
$key = pack('H*', $key);

$iv_size = mcrypt_get_iv_size($cipher, $mode); 
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

// 动态 iv
function t1() {
    global $cipher,$mode,$data,$key,$iv,$iv_size;

    // 加密
    $crypt = mcrypt_encrypt ( $cipher, $key , $data , $mode, $iv );
    $cryptExt = $iv . $crypt; 
    var_dump(base64_encode($cryptExt));

    // 解密
    $iv = substr($cryptExt, 0, $iv_size);
    $crypt = substr($cryptExt, $iv_size);
    $plain = mcrypt_decrypt($cipher, $key, $crypt, $mode, $iv);
    $plain = trim($plain);
    var_dump($data, $plain);
}
//t1();

function t2() {
    global $cipher,$mode,$data,$key,$iv,$iv_size;

    // 加密
    $crypt = mcrypt_encrypt ( $cipher, $key , $data , $mode);
    //var_dump(base64_encode($crypt));

    // 解密
    $plain = mcrypt_decrypt($cipher, $key, $crypt, $mode);
    $plain = trim($plain);
    //var_dump($data, $plain);
}
t2();

