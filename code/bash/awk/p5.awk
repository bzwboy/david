#!/bin/awk -f

#
# 命令行
# ./t.awk
# ./t.awk >/dev/null
# ./t.awk >/dev/null 2>&1
#

function p(msg) {
    printf("%s\n", msg) > "/dev/stdout"
}

function perr(msg) {
    printf("%s\n", msg) > "/dev/stderr"
}

function ptty(msg) {
    printf("%s\n", msg) > "/dev/tty"
}

BEGIN{
    p("/dev/stdout")
    perr("/dev/stderr")
    ptty("/dev/tty")
}

