#!/bin/bash

#
# 通过ssh 端口转发映射使用AWS 服务
# e.g. Redis/MySQL service
#
# @see http://387d2baf.wiz03.com/share/s/0UviKL357Qot2sHakU2ujJwS3RW1j01PmAiy20dhQ-0QwC8g
#
# Usage
#   ./% [command] [key]
#       command     watch,run,stop,start
#       key         see mapping_port variable
#

mapping_port=(
    "pc_redis_uat:6380"
    "pc_mysql_slave_1b:3316"
)

init_env() {
    G_PORT=`handle_port get ${1}`
    G_PID=`check_port ${G_PORT}`
}

myhelp() {
    printf "%25s     %s\n" "Service" "Port"
    echo "       ------------------------------------------"
    for item in ${mapping_port[@]}; do
        arr=(`echo $item | tr ':' ' '`)
        service=${arr[0]}
        port=${arr[1]}
        printf "%25s  |  %s\n" "${service}" "127.0.0.1:${port}"
    done
}

myexp() {
    if [ $? -eq 0 ]; then
        echo "+Ok, success."
    else
        echo "-Err, failure."
    fi
}

# 检查端口是否启用
check_port() {
    local pid="`lsof -i :${1} | awk '{print $2}' | tail -n 1`"
    if [ "$pid" != "" ]; then
        echo $pid
    else
        echo 0
    fi
}

handle_port() {
    for item in ${mapping_port[@]}; do
        arr=(`echo $item | tr ':' ' '`)
        service=${arr[0]}
        port=${arr[1]}
        if [ "${2}" = "${service}" ]; then
            case ${1} in
                "get")
                    echo $port
                    return
                    ;;

                "watch")
                    ret="`lsof -i :${port}`"
                    if [ -n "$ret" ]; then
                        echo "Watch port[$port]..."
                        echo "$ret"
                    else
                        echo "+Ok, port[$port] is idle."
                    fi
                    return
                    ;;

                "stop")
                    echo "Stop the port[$port]..."
                    local pid=`check_port ${port}`
                    if [ $pid -eq 0 ]; then
                        echo "+Ok, this port[$port] is idle."
                    else
                        kill $pid
                        myexp
                    fi
                    return
                    ;;

                *)
                    myhelp
            esac
        fi
    done
}

##########################
# Mapping uat redis port
# Usage
#   redis-cli -p 6380
##########################
start_pc_redis_uat() {
    echo "Launch the port ${G_PORT}..."
    if [ $G_PID -eq 0 ]; then
        ssh -N -f -L ${G_PORT}:dev-payment-center.8sttox.0001.apse1.cache.amazonaws.com:6379 devops
        myexp
    else
        echo "+Ok, port[${G_PORT}] has been launched. pid[$G_PID]."
    fi
}
run_pc_redis_uat() {
    if [ $G_PID -eq 0 ]; then
        start_pc_redis_uat
        echo
    fi
    /usr/local/bin/redis-cli -p ${G_PORT}
}

###################################
# Mapping production slave mysql
# Usage
#   mysql -h127.0.0.1 -udbprod -psTtRMvjPFRFC84uA -P3316 -A pccwpayment
###################################
start_pc_mysql_slave_1b() {
    echo "Launch the port ${G_PORT}..."
    if [ $G_PID -eq 0 ]; then
        ssh -N -f -L ${G_PORT}:payment-db-prod-read1b.cq5al5phkwse.ap-southeast-1.rds.amazonaws.com:3306 devops
        myexp
    else
        echo "+Ok, port[${G_PORT}] has been launched. pid[$G_PID]."
    fi
}
run_pc_mysql_slave_1b() {
    if [ $G_PID -eq 0 ]; then
        start_pc_mysql_slave_1b
        echo
    fi
    /usr/local/bin/mysql -h127.0.0.1 -udbprod -psTtRMvjPFRFC84uA -P${G_PORT} -A pccwpayment
}

################# Handle ##################
if [ -z "$1" -o -z "$2" ]; then
    myhelp
    exit 1
fi

case "$1" in
    "start")
        init_env $2
        start_${2}
        ;;

    "stop")
        init_env $2
        handle_port stop ${2}
        ;;

    "watch")
        init_env $2
        handle_port watch ${2}
        ;;

    "run")
        init_env $2
        run_${2}
        ;;

    *)
        myhelp
esac
