#!/bin/sh
while read line; do
#echo $line

    OLD_IFS="$IFS"
    IFS=" "
    array=($line)
    IFS="$OLD_IFS"

    flag=${array[0]}
    pub_ip=${array[1]}
    priv_ip=${array[2]}

    echo "
# ${flag}
# private ip: ${priv_ip}
# public ip: ${pub_ip}
Host payment-${flag#*i-}
    HostName ${priv_ip}
    Port 22
    User ec2-user
    ProxyCommand ssh ec2-user@admin -p 22 nc %h %p
    IdentityFile /Users/ott002/git/terry/work/ott/pccw-payment-uat.pem
    ForwardAgent Yes"
done < aws_product_server

