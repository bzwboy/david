#!/bin/sh

from_path="/Users/ott002/git/payment-backend"
to_path="/var/www/html/payment_dev"

cd $from_path

#file=(
#    "main/application/controllers/cronjob/cronjob_ais_new_reconcile_file.php"
#    "main/application/models/ais_model.php"
#)
#
#for f in "${file[@]}"; do
#    scp $f ubuntu@uat:${to_path}/$f
#done

if [ -n "$1" ]; then
    scp ${1} ubuntu@uat:${to_path}/${1}
else
    for f in `git st -s | awk '{print $2}'`; do
        #echo $f
        echo "--> $f"
        scp $f ubuntu@uat:${to_path}/$f
        echo
    done
fi

