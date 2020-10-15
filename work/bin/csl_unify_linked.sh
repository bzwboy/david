#!/bin/bash

#
# Linked uat bin
#
# Usage
#     ./% <msisdn> [mode]
#         msisdn    CSL phone number, e.g. 60504295
#         mode      uat or prod, default prod
#

if [ -z "$1" ]; then
    echo "./`basename ` <msisdn> [mode]
     msisdn    CSL phone number, e.g. 60504295
     mode      uat or prod, default prod"
    exit 125
fi

if [ -n "$2" ]; then
    echo "--> $2"
else
    echo "--> prod/qa"
fi

ssh uat -l ubuntu "bash /home/ubuntu/libo/bin/csl_unify_test.sh ${1} ${2}" | jq

