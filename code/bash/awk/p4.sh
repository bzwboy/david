#!/bin/sh

#
# awk 函数练习
#

tmpfile=$HOME/tmp/_a_
echo "aa" > $tmpfile

awk '
function p(name) {
    print name
}
{
    p("bnn")
}
' $tmpfile

rm $tmpfile
