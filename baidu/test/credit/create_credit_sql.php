<?php
set_time_limit(0);

$path = '/home/users/libo38/backup/credit';
$csv = $path . '/credit_limit-20151117.csv';
#$csv = $path . '/tmp.csv';
$log = $path . '/sql_log';
$sqlFile = $path . '/member_credit_X.sql';

// 统计文件大小
$size = 0;
// 文件大小 1M 字节
$sizeMax = 1024 * 900;
// sql文件名后缀
$fileCount = 0;
// 记录条数
$recCount = 0;
// 每个insert 语句最大记录数
$recMax = 100;
// 每个文件记录数
$fileRecCount = 1;

$time = time();
$logFp = fopen($log, 'w');
$csvFp = fopen($csv, 'r');
$tplDB = <<<DB
USE market_member;

DB;
$tplPre = <<<SQL
INSERT INTO member_credit(`pass_uid`,`credit_status`,`credit_value`,`create_time`,`update_time`) VALUES 
SQL;
$tplSuf = <<<SUF
 ON DUPLICATE KEY UPDATE credit_value=VALUES(credit_value), create_time=values(create_time), update_time=values(update_time);
SELECT SLEEP(0.5);

SUF;

while(!feof($csvFp)) {
    $str = trim(fgets($csvFp));
    list($passUid, $creditLimit) = explode(',', $str);
    $passUid = intval($passUid);
    if (0 === $passUid) {
        fwrite($logFp, $str . PHP_EOL);
        continue;
    }
    $creditLimit = intval($creditLimit);
    if (0 === $passUid) {
        fwrite($logFp, $str . PHP_EOL);
        continue;
    }
    $data = array(
        'pass_uid' => $passUid,
        'credit_status' => 1,
        'credit_value' => $creditLimit,
        'create_time' => $time,
        'update_time' => $time,
    );
    $sql = '(' . implode(',', $data) . '),';
    if (0 === $size) {
        $currSqlFile = str_replace('X', $fileCount, $sqlFile);
        $sqlFp = fopen($currSqlFile, 'w');
        $size += fwrite($sqlFp, $tplDB);
        $size += fwrite($sqlFp, $tplPre);
        $size += fwrite($sqlFp, $sql);
        ++$recCount;
    } else {
        if ($sizeMax > ($size+strlen($sql))) {
            if (++$recCount > $recMax) {
                fseek($sqlFp, -1, SEEK_END);
                $sql = $tplSuf . $tplPre . $sql;
                $recCount = 0;
            }
            $size += fwrite($sqlFp, $sql);
        } else {
            fseek($sqlFp, -1, SEEK_END);
            fwrite($sqlFp, $tplSuf);
            fclose($sqlFp);
            echo basename($currSqlFile) . " [${fileRecCount}]\n";
            $size = $recCount = 0;

            $currSqlFile = str_replace('X', ++$fileCount, $sqlFile);
            $sqlFp = fopen($currSqlFile, 'w');
            $size += fwrite($sqlFp, $tplDB);
            $size += fwrite($sqlFp, $tplPre);
            $size += fwrite($sqlFp, $sql);
            ++$recCount;
        }
    }
    ++$fileRecCount;
}

fclose($csvFp);
fclose($logFp);
fseek($sqlFp, -1, SEEK_END);
fwrite($sqlFp, $tplSuf);
fclose($sqlFp);
echo basename($currSqlFile) . " [" . ($fileRecCount-1) . "]\n";


