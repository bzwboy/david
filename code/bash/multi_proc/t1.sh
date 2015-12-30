#!/bin/bash

#
# 后台实现运行多进程
# @see http://www.cnitblog.com/sysop/archive/2008/11/03/50974.aspx
#

# 多进程
multi() {
    for ((i=0;i<5;i++));do
    {
        sleep 3;echo 1>>aa && echo "done!"
    } &
    done
    wait
    cat aa|wc -l
    rm aa
}

# 单进程
single() {
    for ((i=0;i<5;i++));do
    {
        sleep 3;echo 1>>aa && echo "done!"
    } 
    done
    cat aa|wc -l
    rm aa
}

echo "======== 单进程运行 ========"
time single

sleep 1 

echo "======== 多进程运行 ========"
time multi

