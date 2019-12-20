#!/bin/bash

#
# 查看prod PaymentCenter nginx error 日志
#

ret="`cat ~/tmp/logs/nginx_error/error.log | grep error | grep -v forbidden`"
url="`echo "${ret}" | awk -F '"' '{print $2}' | sort | uniq`"

echo "--> Error list"
echo "$ret"
echo -e "\n--> Error uri"
echo "$url"
