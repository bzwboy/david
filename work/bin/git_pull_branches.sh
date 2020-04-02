#!/usr/bin/env bash

branch=(
    "DevelopBranch"
    "qa"
    "staging"
    "prod"
)
base_dir="/Users/ott002/git/payment-backend"

cd $base_dir
exec 1>&2

curr_branch=`git branch -a | grep '*' | awk '{print $2}'`
sleep 1

for br in ${branch[@]}; do
    echo "-- `echo "$br" | awk '{print toupper(substr($0,0,1))tolower(substr($0,2))}'` --"
    git checkout $br
    if [ $? -ne 0 ]; then
        git checkout $br
    fi

    git pull origin $br
    if [ $? -ne 0 ]; then
        git pull origin $br
    fi
    echo
done

echo "-- Return origin branch --"
git checkout $curr_branch
