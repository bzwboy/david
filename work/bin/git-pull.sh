#!/usr/bin/env bash

BASE_DIR="$HOME/git/payment-backend"

cd $BASE_DIR
exec 1>&2

run () {
    local cmd="${1}"

    echo $cmd
    eval $cmd
}

br_list=(
    "DevelopBranch"
    "prod"
    "qa"
    "qa_autoqa"
    "staging"
)

cur_br="`git br | grep \* | cut -c 3-`"

#for br in `git br | cut -c 3-`; do
for br in ${br_list[@]}; do
    echo "-- `echo "$br" | awk '{print toupper(substr($0,0,1))tolower(substr($0,2))}'` --"

    run "git checkout $br"
    if [ $? -ne 0 ]; then
        run "git checkout $br"
    fi

    git pull origin $br
    if [ $? -ne 0 ]; then
        git pull origin $br
    fi
    echo
done

echo "-- Return original branch --"
git checkout $cur_br
