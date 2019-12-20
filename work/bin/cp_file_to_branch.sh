#!/usr/bin/env bash

file=(
        "main/application/helpers/MY_string_helper.php"
     )
from_dir="$HOME/tmp"
to_dir="/Users/ott002/git/payment-backend"

cd $to_dir

for f in "${file[@]}"; do
    echo "-> $f"
    fname="`basename $f`"
    cp $from_dir/$fname $to_dir/$f
done
