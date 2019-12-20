#!/bin/bash

if [ -z "$1" ]; then
    echo "`basename $0` <commit-it>"
    exit 1
fi

git cherry-pick "$1" && git diff HEAD^..HEAD

echo
read -p "Do you wish to push this code? [Yy|Nn] " yn
case $yn in
    [Yy]) 
        echo "git push..."
        git push
        break
        ;;

    [Nn]) 
        exit
        ;;

    *) 
        echo "Please answer yes or no."
esac

