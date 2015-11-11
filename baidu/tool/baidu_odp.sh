#/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */
#!/bin/sh

#
# 操作步骤：
# 1、执行 install 命令，安装 odp 环境
# 2、执行 code_XXX 命令，安装 svn/demo 代码
# 3、执行 start 命令，启动 odp 系统
#

##################
# 参数配置
##################
PRODUCT="baidunuomi"
APP="memberapi"

ODP="$HOME/odp"
TAR="$HOME/tar"
CONF="$HOME/conf"
SVN="$HOME/svn"
JUMBO="$HOME/.jumbo"
RUN="$JUMBO/var/run"

CMD_TAR="tar -zxf"
CMD_MAKE="make"
CMD_CP="cp -a"
CMD_MKDIR="mkdir -p"

FILE_SUFFIX=".tar.gz"
FILE_ODP_NEW="odp-3.0.2-develop-nginx.tar.gz"
FILE_ODP="odp_2-4-1.tar.gz"

########################
# 配置结束
########################

if [ ! -d $ODP ]; then
    mkdir -p $ODP
fi

#######################
# odp 框架/SVN开发代码
######################
# {{{ watch()
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
# }}}

# {{{ install_jumbo()
install_jumbo() {
    cd $HOME
    bash -c "$( curl http://jumbo.baidu.com/install_jumbo.sh )"; source ~/.bashrc
}
# }}}

# {{{ install_odp_new()
# 安装 odp 框架结构
install_odp_new() {
    $CMD_TAR $TAR/$FILE_ODP_NEW -C $ODP >/dev/null 2>&1

    # webserver 配置文件
    cp $CONF/vhost/php_new.conf $ODP/webserver/conf/vhost/php.conf

    # 生成 svn 代码安装包配置文件
    cp $CONF/app_cg/conf.php $ODP/php/phplib/app-cg

    # redis 配置文件
    cp $CONF/redis.conf $ODP/conf

    # mysql 配置文件
    cp $CONF/db/cluster.conf $ODP/conf/db

    # noop
    # 系统安装错误
    $ODP/bin/odp_install >/dev/null 2>&1 
    # 开始安装
    $ODP/bin/odp_install >/dev/null 2>&1
    watch "install odp"
}
# }}}
# {{{ install_odp()
# 安装 odp 框架结构
install_odp() {
    #tar zxf $HOME/repo/odp.tgz -C $HOME

    # webserver 配置文件
    cp $CONF/vhost/php.conf $ODP/webserver/conf/vhost/php.conf

    # 生成 svn 代码安装包配置文件
    cp $CONF/app_cg/conf.php $ODP/php/phplib/app-cg

    # redis 配置文件
    cp $CONF/redis.conf $ODP/conf

    # mysql 配置文件
    cp $CONF/db/cluster.conf $ODP/conf/db
}
# }}}
# {{{ remove_odp()
remove_odp() {
    rm -fr $ODP
    watch
}
# }}}
# {{{ start_odp()
#
# 启动 odp 框架
#
start_odp() {
    local opt="start"

    $ODP/php/sbin/php-fpm $opt
    $ODP/webserver/loadnginx.sh $opt
}
# }}}
# {{{ start_odp_new()
#
# 启动 odp 框架
#
start_odp_new() {
    local opt="start"

    $ODP/php/sbin/php-fpm $opt
    $ODP/hhvm/bin/hhvm_control $opt
    $ODP/webserver/loadnginx.sh $opt
}
# }}}
# {{{ stop_odp
#
# 停止 odp 框架
#
stop_odp() {
    local opt="stop"

    $ODP/webserver/loadnginx.sh $opt
    $ODP/php/sbin/php-fpm $opt
}
# }}}
# {{{ stop_odp_new
#
# 停止 odp 框架
#
stop_odp_new() {
    local opt="stop"

    $ODP/webserver/loadnginx.sh $opt
    $ODP/hhvm/bin/hhvm_control $opt
    $ODP/php/sbin/php-fpm $opt
}
# }}}

# {{{ install_redis()
#
# Redis
#
install_redis() {
    jumbo install redis
}
# }}}
# {{{ remove_redis()
remove_redis() {
    jumbo remove redis
}
# }}}
# {{{ start_redis()
start_redis() {
    cd $HOME
    redis-server $JUMBO/etc/redis.conf
    watch "start redis"
}
# }}}
# {{{ stop_redis()
stop_redis() {
    kill `head -n 1 $JUMBO/$RUN/redis.pid`
    watch "stop redis"
}
# }}}

# {{{ install_mysql()
#
# MySQL
#
install_mysql() {
    jumbo install mysql
}
# }}}
# {{{ remove_mysql()
remove_mysql() {
    jumbo remove mysql
}
# }}}
# {{{ start_mysql()
start_mysql() {
    cd $HOME
    mysqld_safe --defaults-file=$JUMBO/etc/mysql/my.cnf >/dev/null 2>&1 &
    sleep 1
    #ps -ef |grep libo38 |grep mysql
    watch "start mysql"
}
# }}}
# {{{ stop_mysql()
stop_mysql() {
    cd $HOME
    mysqladmin --defaults-file=$JUMBO/etc/mysql/my.cnf -uroot shutdown
    watch "stop mysql"
}
# }}}

# {{{ install()
install() {
    if [ -z "$1" ]; then
        help
        exit 1
    fi
    install_$1
}
# }}}
# {{{ remove()
remove() {
    if [ -z "$1" ]; then
        help
        exit 1
    fi
    remove_$1
}
# }}}
# {{{ start() 
start() {
    if [ -z "$1" ]; then
        help
        exit 1
    fi
    start_$1
}
# }}}
# {{{ stop()
stop() {
    if [ -z "$1" ]; then
        help
        exit 1
    fi
    stop_$1
}
# }}}
# {{{ restart()
restart() {
    if [ -z "$1" ]; then
        help
        exit 1
    fi

    stop_$1

    usleep 1000000

    start_$1
}
# }}}
# {{{ look()
look() {
    if [ -z "$1" ]; then
        help
        exit 1
    fi

    ps -ef |grep $1
}
# }}}

# {{{ make_demo()
make_demo() {
    local app_cg="$ODP/php/phplib/app-cg"
    local out="$app_cg/out/newapp"

    # 生成代码框架到 out 目录内
    php $app_cg/run.php >/dev/null 2>&1
    watch "php run.php"

    # make 代码到 odp 开发环境内
    cd $out
    make dev_pc >/dev/null 2>&1
    watch "make dev_pc"
}
# }}}
# {{{ make_svn
make_svn() {
    member_branch=("member-api" "member-lib")

    local branch="tuangou_4-3-1542_BRANCH"
    local member_api="$SVN/branch/member-api/$branch"
    #local member_lib="$SVN/trunk/${member_branch[1]}"
    local member_lib="$SVN/branch/member-lib/$branch"

    # make api 代码
    cd $member_api
    ./build.sh >/dev/null 2>&1
    watch "生成 ${member_branch[0]} 安装压缩包"
    cd output
    $CMD_TAR "${member_branch[0]}${FILE_SUFFIX}" -C $ODP >/dev/null 2>&1
    watch "发布 ${member_branch[0]} 代码"

    # make lib代码
    cd $member_lib
    ./build.sh >/dev/null 2>&1
    watch "生成 ${member_branch[1]} 安装压缩包"
    cd output
    $CMD_TAR "${member_branch[1]}${FILE_SUFFIX}" -C $ODP >/dev/null 2>&1
    watch "发布 ${member_branch[1]} 代码"
}
# }}}

# {{{ all_demo()
all_demo() {
    watch "停止 odp 服务..."
    stop >/dev/null 2>&1 
    usleep 10000

    watch "卸载 odp..."
    remove >/dev/null 2>&1 
    usleep 10000

    watch "重新安装 odp..."
    install >/dev/null 2>&1
    usleep 10000

    watch "发布 odp 代码..."
    make_demo >/dev/null 2>&1
    usleep 10000

    watch "启动 odp..."
    start >/dev/null 2>&1
}
# }}}
# {{{ help()
help() {
    cat <<H
./$(basename $0) 
    install   [odp|mysql|redis]     安装服务
    remove    [odp|mysql|redis]     卸载服务
    start     [odp|mysql|redis]     启动服务
    stop      [odp|mysql|redis]     停止服务
    restart   [odp|mysql|redis]     重启服务

    make_svn                        发布 SVN 代码到 odp 开发框架中
    make_demo                       发布 demo 代码到 odp 开发框架中
H
    exit 1
}
# }}}

cd $HOME
if [ -z "$1" ]; then
    help
    exit
fi
$*
