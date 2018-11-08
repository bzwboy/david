#!/bin/sh

port="80"
if [ -n "$1" ]; then
    port="$1"
fi

curl http://localhost:${port} $2 $3 $4
