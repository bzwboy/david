#!/bin/sh

#
# 测试 ARGIND 处理逻辑
# 结果：
# awk 带有多个文件时（f1/f2），处理逻辑为：
#（1）处理 f1 内所有的行
#（2）处理 f2 内所有的行
#

f1="$HOME/tmp/f1"
f2="$HOME/tmp/f2"

echo -e "f1\na\nb" > $f1
echo -e "f2\nc\nd" > $f2

awk '
function pl(arr, num) {
    print "==> " num " <=="
    for (i in arr) print arr[i]
}

{
    if (ARGIND == 1) {
        f1[NR] = $0
    }
    pl(f1,1)
    pl(f2,2)
    if (ARGIND == 2) {
        f2[NR] = $0
    }
    pl(f1,3)
    pl(f2,4)
}
END {
    pl(f1,"f1")
    pl(f2,"f2")
}' $f1 $f2

rm $f1 $f2
