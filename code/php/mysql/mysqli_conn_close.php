#!/home/users/libo38/odp/php/bin/php
<?php

# 生成了7个对象
#Bd_Init::init('memberapi');

function mysql_conn() {
    global $my;

    $conf = array (
        'host' => '127.0.0.1',
        'port' => 3306,
        'uname' => 'root',
        'passwd' => NULL,
        'flags' => 0,
        'dbname' => 'test',
    );

    if(!$my->real_connect(
        $conf['host'], $conf['uname'], $conf['passwd'],
        $conf['dbname'], $conf['port'], NULL, $conf['flags']
    )) {
        die('mysql connect fail');
    }

    return 1;
}

// error
// close 后直接在 connect 会导致失败的
#$my = mysqli_init();
#mysql_conn();
#$my->close();
#var_dump($my);
#mysql_conn();

// 一旦被 close 后，如果再连接，需要重新做mysql_init()才可以
$my = mysqli_init();
mysql_conn();
$my->close();
var_dump($my);
unset($my);
$my = mysqli_init(); // 重点！！！
var_dump($my);
mysql_conn();

#$sql = 'select * from member_points limit 1\G'; // 错误的语句，不能有'\G'标识。
$sql = 'select * from member_points limit 1';
$res = $my->query($sql);

$data = array();
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}
print_r($data);
