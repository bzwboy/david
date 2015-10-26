#!/bin/sh

##################
# 参数配置
##################
PRODUCT="bainuo"
APP="member-api"

ODP="$HOME/odp"
TAR="$HOME/tar"
CONF="$HOME/conf"
FILE="odp-3.0.2-develop-nginx.tar.gz"

########################
# 配置结束
########################

if [ ! -d $ODP ]; then
    mkdir -p $ODP
fi

watch() {
    local rmsg="succ"
    local wmsg="failure"

    if [ ! -z "$1" ]; then
        rmsg="$1"
        wmsg="$1"
    fi

    if [ $? -eq 0 ]; then
        echo "+Ok, $rmsg."
    else
        echo "-Fail. $wmsg."
    fi
}

#
# odp 环境安装
#
install() {
    tar zxvf $TAR/$FILE -C $ODP >/dev/null 2>&1

    # 替换文件
    cp $CONF/vhost/php.conf $ODP/webserver/conf/vhost/php.conf

    # 替换 app_cg 配置文件
    cp $CONF/app_cg/conf.php $ODP/php/phplib/app-cg

    # noop
    # 系统安装错误
    $ODP/bin/odp_install >/dev/null 2>&1 
    # 开始安装
    $ODP/bin/odp_install
    watch

    # 创建目录
    mkdir -p $ODP/app/$APP
    mkdir -p $ODP/conf/app/$APP
    mkdir -p $ODP/webroot/$APP
    mkdir -p $ODP/php/phplib/$PRODUCT/api/$APP
}

#
# odp 环境卸载
#
uninstall() {
    rm -fr $ODP/*
    watch
}

#
# 启动 odp 框架
#
start() {
    local opt="start"

    $ODP/php/sbin/php-fpm $opt
    $ODP/hhvm/bin/hhvm_control $opt
    $ODP/webserver/loadnginx.sh $opt
}

#
# 停止 odp 框架
#
stop() {
    local opt="stop"

    $ODP/webserver/loadnginx.sh $opt
    $ODP/hhvm/bin/hhvm_control $opt
    $ODP/php/sbin/php-fpm $opt
}

restart() {
    stop >/dev/null 2>&1
    watch stop

    sleep 10000

    start >/dev/null 2>&1
    watch start
}

code() {
    local app_cg="$ODP/php/phplib/app-cg"
    local out="$app_cg/out/member-api"

    # 生成代码框架到 out 目录内
    php $app_cg/run.php >/dev/null 2>&1
    watch "php run.php"

    # make 代码到 odp 开发环境内
    cd $out
    make dev_pc >/dev/null 2>&1
    watch "make dev_pc"
}

all() {
    watch "停止 odp 服务..."
    stop >/dev/null 2>&1 
    usleep 10000

    watch "卸载 odp..."
    uninstall >/dev/null 2>&1 
    usleep 10000

    watch "重新安装 odp..."
    install >/dev/null 2>&1
    usleep 10000

    watch "发布 odp 代码..."
    code >/dev/null 2>&1
    usleep 10000

    watch "启动 odp..."
    start >/dev/null 2>&1
}

help() {
    echo "./$(basename $0) [install|uninstall|start|stop|restart|make]"
    exit 1
}

cd $HOME
case "$1" in
    install)
        install
        ;;
    uninstall)
        uninstall
        ;;
    start)
        start
        ;;
    stop)
        stop
        ;;
    restart)
        restart
        ;;
    code)
        code
        ;;
    all)
        all
        ;;
    *)
        help
        echo "miss parameters or parameters wrong"
        exit 1
        ;;
esac
