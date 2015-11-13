#!/home/users/libo38/odp/php/bin/php
<?php

Bd_Init::init('memberapi');

$timer = new Bd_Timer(false, Bd_Timer::PRECISION_US);

echo "Read\n";
echo "============================\n";

for ($i = 0, $c = 10; $i < $c; $i++) {
    $timer->start();
    $db = new Bd_DB;
    $db->connect('127.0.0.1', 'root', null, 'test', 3306);
    if (!$db->isConnected(true)) {
        if (!$db->reconnect()) {
            echo "connect mysql fail.";
            exit(1);
        }
    }

    $sql = 'select * from member_points limit 1;';
    $ret = $db->query($sql);
    $db->close();

    $readTime = $timer->stop();
    #print_r($ret);
    echo "${i}: ${readTime} us\n";
    unset($db, $ret);
}
sleep(1);
echo "\n";

echo "Write\n";
echo "============================\n";
for ($i = 0, $c = 10; $i < $c; $i++) {
    $timer->start();
    $db = new Bd_DB;
    $db->connect('127.0.0.1', 'root', null, 'test', 3306);
    if (!$db->isConnected(true)) {
        echo "connect mysql fail.";
        exit(1);
    }

    $pass_uid = md5(posix_getpid() . microtime(true) . mt_rand());
    $sql = 'insert into member_points(pass_uid, create_time) values(\'' . $pass_uid . '\', ' . time() . ');';
    $ret = $db->query($sql);
    #var_dump($ret);
    $db->close();

    $readTime = $timer->stop();
    echo "${i}: ${readTime} us\n";
    unset($db, $ret);
}

