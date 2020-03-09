#!/bin/bash

#
# Format json string to postman style
#
# Usage
#   ./% 'json string'
#

if [ -z "$1" ]; then
    echo "Please input the json string"
    exit 1
fi

json="$1"
#json='{"user_id":null,"region_id":"SG","service_type":"VIU","code":"4304824426227025","language_flag_id":"3"}'
magic() {
    echo "$1" | sed 's/["\{\}]//g' | sed $'s/,/\\\n/g'
}
magic "$json" && magic "$json" | pbcopy


