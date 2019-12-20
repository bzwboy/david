#!/usr/bin/env bash

#
# export cms user data
#
# Usage
#   ./dump_cms_user.sh [to]
#       to  ec2-user@cron-nowtv:/home/ec2-user/libo/dat
#

FILE_NAME="export_cms_user_`date +'%Y%m%d'`_`date +%s`.dat"
REMOTE_DAT_DIR="/home/ubuntu/libo/dat"

ssh redmine -l ubuntu "/home/ubuntu/libo/bin/dump_cms_user.sh ${FILE_NAME}"
scp ubuntu@redmine:${REMOTE_DAT_DIR}/${FILE_NAME} $HOME/tmp
echo -e "+Ok, export succ.\n"

echo "move dat..."
if [ -n "$1" ]; then
    scp $HOME/tmp/${FILE_NAME} "$1"
else
    scp $HOME/tmp/${FILE_NAME} "ec2-user@cron-nowtv:/home/ec2-user/libo/dat"
fi
echo "+Ok, move succ."
