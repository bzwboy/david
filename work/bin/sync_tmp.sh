#!/bin/sh

#
# sync code to cron-nowtv2
#

from_path="/Users/ott002/git/payment-backend/bin"

cd $from_path

echo "--- Deploy nowtv ---"
to_path="/home/ec2-user/libo/bin"
scp -r * ec2-user@cron-nowtv:${to_path}
#echo
#
#echo "--- Deploy nowtv2 ---"
#to_path="/home/ubuntu/libo/bin"
#scp -r * ubuntu@cron-nowtv2:${to_path}
#echo
#
#echo "--- Deploy payment ---"
#to_path="/home/ec2-user/libo/bin"
#scp -r * ec2-user@cron-payment:${to_path}

#echo "--- Deploy uat ---"
#to_path="/home/ubuntu/libo/bin"
#scp -r * ubuntu@uat:${to_path}
