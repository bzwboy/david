#!/bin/sh

#
# 比较 innodb/myisam engine 插入数据的效率
# 前提：都没有索引，只包含两个字段
#
# CREATE TABLE `innodb` (
#   `id` int(11) NOT NULL DEFAULT '0',
#   `name` varchar(20) NOT NULL DEFAULT ''
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8
# 
# CREATE TABLE `myisam` (
#   `id` int(11) NOT NULL DEFAULT '0',
#   `name` varchar(20) NOT NULL DEFAULT ''
# ) ENGINE=MyISAM DEFAULT CHARSET=utf8
#
# 结论：
# $ sh innodb_vs_myisam_insert_time.sh
#      insert innodb engine...
#      innodb cost:5559 ms
#      insert myisam engine...
#      myisam cost:4964 ms
#      innodb VS myisam insert:595 ms
# myisam 插入速度优于 innodb 引擎
#

# getTiming func
. $HOME/git/david/i_libo/env/tool/bash/xfunc
DB="mysql -h127.0.0.1 -uroot -Dtest"

# innodb
$DB -s -e "truncate table innodb"

echo "insert innodb engine..."
dts=$(date +%s.%N)
sql="insert into innodb values"
for i in {1..1000}; do
    innodb="${sql}($i,'a${i}')"

    ## for debug...
    #echo $innodb;exit;

    $DB -s -e "$innodb"
done
dte=$(date +%s.%N)
echo -n "innodb cost:"
innodb_ms=$(getTiming $dts $dte)
echo $innodb_ms

# sleep
sleep 1

# myisam
$DB -s -e "truncate table myisam"

dts=$(date +%s.%N)
echo "insert myisam engine..."
sql="insert into myisam values"
for i in {1..1000}; do
    myisam="${sql}($i,'a${i}')"
    $DB -s -e "$myisam"
done
dte=$(date +%s.%N)
echo -n "myisam cost:"
myisam_ms=$(getTiming $dts $dte)
echo $myisam_ms
echo "innodb VS myisam insert:$(( $(echo $innodb_ms|cut -d ' ' -f 1) - $(echo $myisam_ms|cut -d ' ' -f 1) )) ms"

