#!/bin/sh

#
# 查找ci infrastructure log
#

cd $HOME/tmp/logs/ci_error

for file in `ls ${1}*`; do
   echo "--> $file"

   cat "$file" | grep -v Function | grep -v '<\?php' \
       | grep -v 'Undefined variable' | grep -v 'Undefined index' | grep -v 'Severity: Notice' \
       | grep -v 'Cache: Redis authentication failed' \
       | grep -v '404 Page Not Found' \
       | grep -v 'Undefined property' \
       | grep -v 'Trying to get property of non-object' \
       | grep -v '\/var\/app\/current\/main\/application\/libraries\/Apple_iap_tools.php 209'
   echo
done
