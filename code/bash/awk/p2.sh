#!/bin/sh

#
# stdin 实现交互
# 通过 - 实现
#

echo "libo love bnn" |awk 'BEGIN{
    printf("Enter name: ")
    getline name < "-"
}
{
}
END{
    print name
}' -
