<?php

#
# 结论：通过 select for update 方式产生的并发控制
# 会阻塞数据记录，性能不如通过 update connectiont_id() 方式优化
#

// 利用 mysql update 和 mysqliection_id() 实现并发控制
$mysqli = new mysqli('127.0.0.1', 'root', '', 'test', 3306);

function query($sql)
{
    global $mysqli;

    $row = array();
    $res = $mysqli->query($sql);
    for ($i = 0, $c = $res->num_rows; $i < $c; $i++) {
        $row[] = $res->fetch_assoc();
    }

    return $row;
}

// 获取当前
$ret = query('select connection_id() as conn_id');
$cid = $ret[0]['conn_id'];
echo 'connection_id [' . $cid . "]\n";

$mysqli->autocommit(false);
$ret = query('select id from concurrency where pass_uid=0 limit 1 for update');
xv($ret);
// 模拟并发
sleep(3);

query("update concurrency set pass_uid=${cid} where id=" . $ret[0]['id']);
$mysqli->commit();

