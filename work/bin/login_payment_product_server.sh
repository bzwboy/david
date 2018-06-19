#!/bin/sh

#
# login payment product server
# @param instance_id
# ./% <instance_id>

base_dir="$HOME/git/terry/work/bin"
server_file="${base_dir}/aws_product_server"

if [ -n "$1" ]; then 
    instance=$1
    line=`cat $server_file | grep $instance`
else
    line=`sort -R ${server_file} | head -1` 
    serv=`echo $line | awk '{print $1}'`
    instance=${serv#*i-}
fi

echo "\033[32m$line\033[0m"
ssh payment-${instance}
