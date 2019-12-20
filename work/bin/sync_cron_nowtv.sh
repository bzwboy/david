#!/bin/sh

from_path="/Users/ott002/git/payment-backend"
to_path="/home/ec2-user/local/debug"

cd $from_path
for f in `git st -s | awk '{print $2}'`; do
#echo $f
    scp $f ec2-user@cron-nowtv:${to_path}/$f
done
