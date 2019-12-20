#!/bin/sh

#
# 支付中心代码变动工具
#
cd /Users/ott002/git/payment-backend
git st |grep modified |awk '{print $2}' |sort |uniq
