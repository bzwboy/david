#!/bin/sh

cd $HOME/git/ottreporter

git status -s | awk '{print $2}' | while read fpath; do
    scp $fpath ubuntu@uat-ottreporter:/var/www/html/ottreporter/$fpath
done
