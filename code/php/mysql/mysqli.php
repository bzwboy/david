<?php
error_reporting(E_ALL);

$host = '127.0.0.1';
$port = 3306;
$db = 'test';

$username = 'root';
$passwd = '';

$mysqli = new mysqli($host, $username, $passwd, $db, $port);
$result = $mysqli->query('select * from t1');

while ($row = $result->fetch_assoc()) {
    if ($row['create_time'] && $row['create_time'] != '0000-00-00 00:00:00') {
        $row['create_time'] = strtotime($row['create_time']);
    }
    var_dump($row);
}

$result->free();
$mysqli->close();

