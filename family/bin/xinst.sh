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

    make
    myexp

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

    make
    myexp

    make install
    myexp
}

install_swoole() {
     ./configure \
        --prefix=/home/libo/local \
        --with-php-config=/home/libo/local/php5/bin/php-config
    myexp

    make
    myexp

    make install
    myexp
}

install_${1}
