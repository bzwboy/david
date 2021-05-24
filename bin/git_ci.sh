#!/bin/bash

git add . 
git commit -a -m "`date +%c`"
git push

echo 
git status
