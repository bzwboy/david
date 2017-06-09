#!/bin/sh

#
# 安装环境脚本
#

SOURCE="/home/libo/source"

[ -z $1 ] && {
    echo "$0 [libxml2]"
    exit 1
}

myexp() {
    [ $? -ne 0 ] && {
        echo "-Err"
        exit $?
    }
}

install_libxml2() {
    local _dir="$SOURCE/libxml2-2.9.4"
    cd $_dir
    ./configure \
        --prefix=$HOME/local \
        --with-python=$HOME/local \
        --with-python-install-dir=$HOME/local
    myexp
    sleep 1

    make
    myexp
    sleep 1

    make install
    myexp
}

install_php5() {
    local _dir="$SOURCE/php-5.6.30"
    cd $_dir

    # install dependency
    yum install -y gcc gcc-c++ gd-devel libmcrypt-devel libcurl-devel openssl-devel zlib-devel

    ./configure \
    --prefix=/home/libo/local/php5 \
    --enable-fpm \
    --enable-mysqlnd \
    --enable-zip \
    --enable-mbstring \
    --enable-exif \
    --with-openssl \
    --with-mysql \
    --with-mysqli \
    --with-curl \
    --with-zlib \
    --with-gd \
    --with-mcrypt
    myexp
    sleep 1

    make
    myexp
    sleep 1

    make install
    myexp
}

install_php7() {
    local _dir="$SOURCE/php-7.1.5"
    cd $_dir

    # install dependency
    #sudo yum install -y gcc gcc-c++ gd-devel libmcrypt-devel libcurl-devel openssl-devel zlib-devel libxml2-devel.x86_64
    #myexp

    make clean
    ./configure \
    --prefix=/home/libo/local \
    --with-config-file-path=/home/libo/local/etc \
    --with-pdo-mysql=/home/mysql/mysql-5.7.18 \
    --enable-fpm \
    --enable-mysqlnd \
    --enable-zip \
    --enable-mbstring \
    --enable-exif \
    --enable-sockets \
    --with-openssl \
    --with-mysqli \
    --with-curl \
    --with-zlib \
    --with-gd \
    --with-mcrypt
    myexp
    sleep 1

    make
    myexp
    sleep 1

    make install
    myexp
}

install_swoole() {
    local _dir="$SOURCE/swoole-1.9.11"
    cd $_dir

    make clean
     ./configure \
        --prefix=/home/libo/local \
        --with-php-config=/home/libo/local/bin/php-config
    myexp
    sleep 1

    make
    myexp
    sleep 1

    make install
    myexp
}

install_redis() {
    local _dir="$SOURCE/redis-3.2.9"
    cd $_dir

    make PREFIX=/home/libo/local install
    cd $_dir
}

install_nginx() {
    local _dir="$SOURCE/nginx-1.12.0"
    cd $_dir

    make clean
    ./configure \
        --prefix=$HOME/local \
        --conf-path=$HOME/local/etc/nginx/nginx.conf \
        --error-log-path=$HOME/local/logs/nginx/error.log \
        --pid-path=$HOME/local/run/nginx.pid \
        --lock-path=$HOME/local/run/nginx.lock \
        --with-stream \
        --with-stream_realip_module \
        --with-pcre \
        --http-client-body-temp-path=$HOME/local/temp/client-body \
        --http-proxy-temp-path=$HOME/local/temp/proxy \
        --http-fastcgi-temp-path=$HOME/local/temp/fastcgi \
        --http-uwsgi-temp-path=$HOME/local/temp/uwsgi \
        --http-scgi-temp-path=$HOME/local/temp/scgi \
        --with-debug
    myexp
    sleep 1

    make
    myexp
    sleep 1

    make install
    myexp
}

install_${1}
