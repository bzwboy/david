#!/bin/sh

#
# 获取prod nginx error log
#

cd $HOME/bin/insight

if [ -z "$1" ]; then
    cur_date="`date +%Y%m%d`"
else
    cur_date="$1"
fi

LOG_PATH="$HOME/tmp/logs/nginx_error"

hash="`date +%s|md5`"
batch="${hash:0:6}"
prefix="payment_error"
batch_prefix="${batch}-${prefix}"

ERR_LOG="$LOG_PATH/${batch}-error.log"


>$ERR_LOG

for priv_ip in `ec2_list|awk '{print $3}'`; do
    echo "--> Pull ${priv_ip} log..."

    log_name="${LOG_PATH}/${batch_prefix}-${priv_ip}.log"
    scp ubuntu@prod-pc-webapi_${priv_ip}:/var/log/nginx/${prefix}.log $log_name

    echo " ==> ${priv_ip} <==" >> $ERR_LOG
    cat $log_name >> $ERR_LOG
    echo "" >> $ERR_LOG

    echo
done
