#!/bin/bash

#
# Reset Studio 3T expiration to 30 days
#
# Usage
#   bash %
#
 
read -p "If backup your connection...[Y/n] " answer
if [ "$answer" != "Y" ]; then
    echo "Stop this process!"
    exit 127
fi

rm -f ~/Library/Preferences/3t.*
rm -rf ~/.3T
rm -rf ~/.cache/ftuwWNWoJl-STeZhVGHKkQ--
 
ftPath=`find /var/folders -name "ftuwWNWoJl-STeZhVGHKkQ--" -print 2>&1 | fgrep -v "Permission denied" | fgrep -v "Operation not permitted"`
t3Path=`dirname ${ftPath}`/t3
 
if [ -e ${ftPath} ];then
    rm -rf ${ftPath}
fi
 
if [ -e ${t3Path} ];then
    rm -rf ${t3Path}
fi
 
echo "删除文件成功，请立即重启电脑生效"
echo "如果不想立刻重启，那么请在重启电脑前，都不要重新运行studio3T, 否则执行脚本将不起作用"

