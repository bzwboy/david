#!/bin/bash

#
# Compare the files which is committed.
#
# Usage
#   % <path/file>
#

cd $HOME/git/payment-backend

cid="`git log -- "${1}" | grep -E '^commit ' | head -n 5 | awk '{print $2}'`"
head="`echo "$cid" | sed -n '1,1p'`"
second="`echo "$cid" | sed -n '2,2p'`"

git diff ${second}..${head} -- ${1}

