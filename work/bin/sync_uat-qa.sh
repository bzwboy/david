#!/usr/bin/env bash

cd /Users/ott002/git/payment-backend

CMD_BASE_DIR="/Users/ott002/bin"

myexp() {
    if [ $? -eq 0 ]; then
        echo "+Ok"
    else
        echo "-Err"
    fi
}

# update uat
upgrade_uat() {
    echo -n "Update Uat Env... "
    git checkout DevelopBranch >/dev/null 2>&1
    myexp

    while read item; do
        echo "-> $item"
        $CMD_BASE_DIR/sync_uat.sh $item
        myexp
    done < $CMD_BASE_DIR/update_file
}

# update qa
upgrade_qa() {
    echo -n "Update QA Env... "
    git checkout qa >/dev/null 2>&1
    myexp

    while read item; do
        echo "-> $item"
        $CMD_BASE_DIR/sync_qa.sh $item
        myexp
    done < $CMD_BASE_DIR/update_file
}

if [ -z "$1" ]; then
    upgrade_uat
    echo
    upgrade_qa
else
    upgrade_${1}
fi
