<?php
set_time_limit(0);

require_once 'conf_global.php';
$app  = new Yaf_Application(PATH_RHEA_ETC . "application.ini", 'rhea');
$app->bootstrap();

require_once PATH_RHEA_LIB . 'em_certificate.class.php';
$cert = new em_certificate;

$pkey_pair_num = 100;

require_once PATH_RHEA_LIB . 'member/em_member_operator_pkey.class.php';

/*
// 20-21 sec
$t = microtime(true);
for ($i = 1, $c = $pkey_pair_num; $i <= $c; $i++) {
    $cert->create_private();
    $pub_key = $cert->get_pubkey();
    $priv_key = $cert->get_privkey();
    printf("+Ok, Set up %d key pair succ!\r", $i);
}
echo "\n";
echo microtime(true)-$t;
echo "\n";
 */

$t = 0;
for ($i = 1, $c = $pkey_pair_num; $i <= $c; $i++) {
    $t1 = microtime(true);
    $cert->create_private();
    $cert->free();
    $t2 = microtime(true);
    $t += $t2-$t1;

    printf("%d\r", $i);
}
echo $t/$pkey_pair_num . "\n";

$config = em_config::get2('openssl_config');
$t = 0;
for ($i = 1, $c = $pkey_pair_num; $i <= $c; $i++) {
    $t1 = microtime(true);
    $res = openssl_pkey_new($config);
    openssl_pkey_free($res);
    $t2 = microtime(true);
    $t += $t2-$t1;
    printf("%d\r", $i);
}
echo $t/$pkey_pair_num . "\n";
