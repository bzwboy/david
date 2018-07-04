#!/bin/sh

#
# 浏览.ssh/config 结构
#

cd $HOME

i=1
printf "%25s     %s\n" "Host" "Ip"
echo "       ------------------------------------------"
for item in `cat .ssh/config | grep Host | grep -v \#`; do
    if [ $(($i%2)) -eq 0 ]; then
        if [ -z $line ]; then
            line=$item
        else
            printf "%25s  |  %s\n" $line $item
        fi
    fi

    if [ $(($i%4)) -eq 0 ]; then
        line=""
    fi

    i=$[i+1]
done
