#!/bin/sh

#
# awk 程序交互练习一
#

awk 'BEGIN{
    printf("Enter name: ")
    getline name < "-"
    print name
}'
