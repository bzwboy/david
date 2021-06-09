#!/bin/bash

cd $HOME/git/terry

echo "==> git-add <=="
git add . 
echo 

echo "==> git-commit <=="
git commit -a -m "`date +%c`"
echo 

echo "==> git-push <=="
git push
echo 

echo "==> git-status <=="
git status
