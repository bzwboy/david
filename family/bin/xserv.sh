#!/bin/sh

#
# 系统启动停止命令
#

##########################
local_dir="$HOME/local"

##########################

#
# help
#
myhelp() {
    echo <<HLP
    ./$0 [mode] [module]
    mode    start|stop|restart
    module  redis|mysql
HLP
}

#
# error
#
myerr() {
    if [ 0 -ne $? ]; then
        echo -e "\e[41;37m-Err, stop process.\e[0m"
        exit $?
    else
        echo "+Ok, succ"
    fi
}

#
# Redis
#
start_redis() {
    redis-server $local_dir/etc/redis.conf
}
stop_redis() {
    kill -9 $(cat $local_dir/run/redis_6379.pid)
}

#
# mysql
#
mysql_dir="${local_dir}/mysql"
start_mysql() {
    cd $mysql_dir
    ./bin/mysqld_safe --defaults-file=${local_dir}/etc/my_57.cnf --disable-partition-engine-check >/dev/null 2>&1 &
    myerr
}
stop_mysql() {
    cd $mysql_dir
    ./bin/mysqladmin -uroot -S ${local_dir}/run/mysql.sock shutdown
    myerr
}
install_mysql() {
    # A temporary password is generated for root@localhost: (ferk9nzsIml
    cd $mysql_dir
    ./bin/mysqld --user=root --basedir=${local_dir}/mysql --datadir=${local_dir}/data/mysql --initialize
}

#
# restart
#
restart() {
    stop_$1
    sleep 1
    start_$1
}

mode="start"
if [ -n "$2" ]; then
    mode="$2"
fi

module=""
if [ -n "$1" ]; then
    module="$1"
fi
if [ -z "$module" ]; then
    myhelp
    exit 1
fi

# 执行操作
if [ ${mode} != "restart" ]; then
    ${mode}_${module}
else
    restart $module
fi
