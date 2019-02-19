#!/bin/sh

#
# 浏览.ssh/config 结构
#

cd $HOME

i=1
for item in `cat .ssh/config | grep Host | grep -v \#`; do
    if [ $(($i%2)) -eq 0 ]; then
        if [ -z $line ]; then
            line=$item
        else
            if [ -n "$1" ]; then
                if [ -n "`echo $line | grep $1`"  ]; then
                    printf "%25s  |  %s\n" $line $item >> _tmp_
                fi
            else
                printf "%25s  |  %s\n" $line $item >> _tmp_
            fi
        fi
    fi

    if [ $(($i%4)) -eq 0 ]; then
        line=""
    fi

    i=$[i+1]
done
if [ ! -f _tmp_ ]; then
    echo "Not Found!"
    exit 0
fi
printf "%25s     %s\n" "Host" "Ip"
echo "       ------------------------------------------"
sort -b _tmp_
rm _tmp_
