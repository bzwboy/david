#!/usr/bin/env bash

#
# 重启mac 音频服务
#

sudo killall coreaudiod
if [ $? -eq 0 ]; then
    echo "+Ok."
else
    echo "-Err!"
fi
