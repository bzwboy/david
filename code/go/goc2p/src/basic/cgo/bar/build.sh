#!/bin/sh

[ -f libbar.so ] && rm libbar.so
gcc -shared -fPIC -o libbar.so bar.c
