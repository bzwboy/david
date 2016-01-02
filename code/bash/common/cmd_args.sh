#!/bin/sh

#
# $@/$*/$# 区别
# @see http://blog.chinaunix.net/uid-26527046-id-3336483.html
#

# $0 a "b b" c
 
if [ $# -eq 0 ]; then
#    echo $0 'a "b b" c' >&2
#    exit 1
    echo -e "Example: $0 a \"b b\" c\n"
fi

echo '==> $* <=='
for i in $*; do
    echo $i
done
echo

echo '==> "$*" <=='
for i in "$*"; do
    echo $i
done
echo

echo '==> $@ <=='
for i in $@; do
    echo $i
done
echo

echo '==> "$@" <=='
for i in "$@"; do
    echo $i
done
echo

echo '==> $# <=='
echo $#
echo
