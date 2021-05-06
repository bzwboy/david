#!/bin/bash

#
# Quickly push anything
#
# Usage
#   ./%
#

git add . && git ci -a -m "`date +%c`" && git pull && git push && git lg | head
