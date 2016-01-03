#!/bin/sh

#
# awk 脚本参数传递练习
#

# Test-1
echo "==> Test-1 <=="
tmpfile="$HOME/tmp/_a_"
echo "aa" >$tmpfile

awk 'BEGIN{ 
    OFS = "\t"
    print "begin", name
}
{
    print "run", name
}' name=libo $tmpfile
rm $tmpfile

# Test-2
echo "==> Test-2 <=="
awk -v name=libo 'BEGIN{ 
    OFS = "\t"
    print "begin", name
}'

