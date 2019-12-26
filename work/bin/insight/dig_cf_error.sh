#!/bin/sh

#
# 查找CloudFront 日志
#

cd $HOME/tmp/logs/cloud_front

gunzip *.gz

for file in `ls *${1}*`; do
    echo "--> $file"

    while read line; do
        st="`echo "$line" | grep -v '^#' | awk '{print $9}'`"
        if [ -z "$st" ]; then
            continue
        fi

        if [ "$st" -ge 500 ]; then
            echo $line
        fi
    done < $file;
    echo
done

