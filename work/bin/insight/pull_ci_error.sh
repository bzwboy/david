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

LOG_PATH="$HOME/tmp/logs/ci_error"

hash="`date +%s|md5`"
batch="${hash:0:6}"
prefix="payment_log"
batch_prefix="${batch}-${prefix}"

for priv_ip in `./ec2_list|awk '{print $3}'`; do
    echo "--> Pull ${priv_ip} log..."

    log_name="${LOG_PATH}/${batch_prefix}-${priv_ip}-${cur_date}.log"
    scp ubuntu@prod-pc-webapi_${priv_ip}:/tmp/${prefix}-${cur_date}.php $log_name

    echo
done
