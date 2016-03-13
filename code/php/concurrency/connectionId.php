<?php

#
# 通过 update connection_id() 方式实现并发控制
#

// 利用 mysql update 和 connection_id() 实现并发控制
$conn = new mysqli('127.0.0.1', 'root', '', 'test', 3306);

function query($sql)
{
    global $conn;

    $row = array();
    $res = $conn->query($sql);
    for ($i = 0, $c = $res->num_rows; $i < $c; $i++) {
        $row[] = $res->fetch_assoc();
    }

    return $row;
}

// 获取当前
$ret = query('select connection_id() as conn_id');
echo 'connection_id [' . $ret[0]['conn_id'] . "]\n";

$conn->autocommit(true);
$ret = query('update concurrency set pass_uid=connection_id() where pass_uid=0 limit 1');

// 模拟并发
sleep(3);

$ret = query('select * from concurrency where pass_uid=connection_id()');
xv($ret);

