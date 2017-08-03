#!/bin/sh

#
# 运行脚本
#

[ $# -ne 2 ] && {
    echo "-Err, $0 redis start"
    exit 1
}

myerr() {
    if [ 0 -ne $? ]; then
        echo -e "\e[41;37m-Err, stop process.\e[0m"
        exit $?
    else
        echo "+Ok, ${1} succ"
    fi
}

BASEDIR="/home/libo/local"
ETC="${BASEDIR}/etc"

<<<<<<< HEAD

=======
>>>>>>> ea404b9... 合并配置文件
################# redis  #################
start_redis() {
    cd $BASEDIR
    ./bin/redis-server ${ETC}/redis.conf --loglevel verbose
    myerr
}
stop_redis() {
    kill -9 $(cat $BASEDIR/run/redis_6379.pid)
    myerr
}
reload_redis() {
    echo "Stop redis ..."
    stop_redis 
    sleep 1
    echo "Start redis ..."
    start_redis
}
watch_redis() {
    ps -ef |grep redis-server
}

################# nginx #################
start_nginx() {
    sudo $HOME/local/sbin/nginx 
}
stop_nginx() {
    sudo $HOME/local/sbin/nginx -s stop
}
reload_nginx() {
    sudo $HOME/local/sbin/nginx -s reload
}
watch_nginx() {
    ps -ef |grep --col nginx
}

################# phpfpm #################
start_phpfpm() {
    sudo $HOME/local/sbin/php-fpm -y $HOME/local/etc/php-fpm.conf
}
stop_phpfpm() {
    sudo kill $(cat /home/libo/local/run/php-fpm.pid)
}
reload_phpfpm() {
    sudo kill -USR2 $(cat /home/libo/local/run/php-fpm.pid)
}
watch_phpfpm() {
    ps -ef |grep --col php-fpm
}

################# xphp #################
start_xphp() {
    start_phpfpm
    myerr "start phpfpm"
    sleep 1

    start_nginx
    myerr "start nginx"
}
stop_xphp() {
    stop_nginx
    myerr "stop nginx"
    sleep 1

    stop_phpfpm
    myerr "stop phpfpm"
}
reload_xphp() {
    stop_xphp
    start_xphp
}

# run
${2}_${1}
