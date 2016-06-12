<?php
/**
 * mcrypt 对称加密算法
 *
 * @param string $string    加密串
 * @param string $secret    密钥
 * @return string
 */
function mcryptEncodeString($string, $secret)
{
    $md5_v = md5($secret);
    $td = mcrypt_module_open('rijndael-128', '', 'cbc', '');
    $key = substr($md5_v, 0, 16);
    $iv = strrev(substr($md5_v, 0, 16));
    mcrypt_generic_init($td, $key, $iv);
    $string = mcrypt_generic($td, trim($string));
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return base64_encode($string);
}

/**
 * mcrypt 解密算法
 *
 * @param string  $string    加密串
 * @param string  $secret    密钥
 * @return string
 */
function mcryptDecodeString($string, $secret)
{
    $string = base64_decode($string);
    if (empty($string)) {
        return false;
    }
    $md5_v = md5($secret);
    $td = mcrypt_module_open('rijndael-128', '', 'cbc', '');
    $key = substr($md5_v, 0, 16);
    $iv = strrev(substr($md5_v, 0, 16));
    mcrypt_generic_init($td, $key, $iv);
    $string = mdecrypt_generic($td, $string);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return trim($string);
}

$data = '15811261604';
$secret = 12345678;

$crypt = mcryptEncodeString($data, $secret);
//var_dump($crypt);

$plain = mcryptDecodeString($crypt, $secret);
//var_dump($data, $plain);
