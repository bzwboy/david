#!/bin/sh

#
# 系统启动停止命令
#

##########################
local_dir="$HOME/local"

##########################

# {{{ help
myhelp() {
    echo <<HLP
    ./$0 [mode] [module]
    mode    start|stop|restart
    module  redis|mysql
HLP
}
# }}}
# {{{ myerr
myerr() {
    if [ 0 -ne $? ]; then
        echo -e "\e[41;37m-Err, stop process.\e[0m"
        exit $?
    else
        echo "+Ok, succ"
    fi
}
# }}}
# {{{ restart
restart() {
    stop_$1
    sleep 1
    start_$1
}
# }}}

# {{{ Redis
start_redis() {
    redis-server $local_dir/etc/redis.conf
    myerr
}
stop_redis() {
    kill -9 $(cat $local_dir/run/redis_6379.pid)
    myerr
}
watch_redis() {
    ps -ef |grep redis-server
}
# }}}
# {{{ mysql55
start_mysql55() {
    cd $local_dir/mysql55
    sudo ./bin/mysqld_safe --user=root \
    --datadir=${local_dir}/data/mysql55 \
    --basedir=${local_dir}/mysql55 \
    --log-error=${local_dir}/log/mysql55/mysql \
    --pid-file=${local_dir}/run/mysql55.pid \
    --socket=${local_dir}/run/mysql55.sock & 
    myerr
}
stop_mysql55() {
    cd $local_dir/mysql55
    sudo ./bin/mysqladmin -uroot -S ${local_dir}/run/mysql55.sock shutdown
    #sudo ./bin/mysqladmin -uroot shutdown
    myerr
}
install_mysql55() {
    cd $local_dir/mysql55
    sudo ./scripts/mysql_install_db --user=root --basedir=${local_dir}/mysql55 --datadir=${local_dir}/data/mysql55
}
# }}}
# {{{ mysql56
start_mysql56() {
    cd $local_dir/mysql56
    ./bin/mysqld_safe --defaults-file=${local_dir}/etc/my56.cnf >/dev/null 2>&1 &
    myerr
}
stop_mysql56() {
    cd $local_dir/mysql56
    ./bin/mysqladmin -uroot -S ${local_dir}/run/mysql56.sock shutdown
    myerr
}
install_mysql56() {
    cd $local_dir/mysql56
    ./scripts/mysql_install_db --user=root --basedir=${local_dir}/mysql56 --datadir=${local_dir}/data/mysql56
}
# }}}
# {{{ mysql57
start_mysql57() {
    cd $local_dir/mysql57
    ./bin/mysqld_safe --defaults-file=${local_dir}/etc/my57.cnf --disable-partition-engine-check >/dev/null 2>&1 &
    myerr
}
stop_mysql57() {
    cd $local_dir/mysql57
    ./bin/mysqladmin -uroot -S ${local_dir}/run/mysql57.sock shutdown
    myerr
}
install_mysql57() {
    # [Note] A temporary password is generated for root@localhost: .(Yz)&sO4j8g
    cd $local_dir/mysql57
    ./bin/mysqld --user=root --basedir=${local_dir}/mysql57 --datadir=${local_dir}/data/mysql57 --initialize
}
# }}}

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
