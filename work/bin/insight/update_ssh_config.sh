#!/bin/sh

#
# 更新.ssh/config 机器列表
#

host_tpl() {
    local priv_ip="${1}"

    echo "Host prod-pc-webapi_${priv_ip}
    HostName $priv_ip
    Port 22
    User ubuntu
    ProxyCommand ssh ec2-user@admin -p 22 nc %h %p
    IdentityFile /Users/ott002/iCloud/viu/pccw-payment-uat.pem
    StrictHostKeyChecking no
    ForwardAgent Yes"
}

cd $HOME/bin/insight
SSH_CONFIG_FILE="$HOME/.ssh/config"

install() {
    echo "Get ec2 instance list..."
    ec2_list="`ssh -l ubuntu staging "/home/ubuntu/libo/bin/insight/ec2_list" | awk '{print $2}'`"

    echo "# -- Auto --" >> $SSH_CONFIG_FILE
    for priv_ip in $ec2_list; do
        host_tpl $priv_ip >> $SSH_CONFIG_FILE
    done
    echo "# -- End --" >> $SSH_CONFIG_FILE
    echo "+Ok, Update ssh config success."
}

erase() {
    echo "Erase ssh config..."
    s="`grep -ns '# -- Auto --' $SSH_CONFIG_FILE | awk -F: '{print $1}'`"
    if [ -z "$s" ]; then
        echo "-Err, Start flag error"
        return
    fi

    e="`grep -ns '# -- End --' $SSH_CONFIG_FILE | awk -F: '{print $1}'`"
    if [ -z "$e" ]; then
        echo "-Err, End flag error"
        return
    fi

    sed -i '' "${s},${e}d" $SSH_CONFIG_FILE
    echo "+OK, Erase success"
}

erase
install
