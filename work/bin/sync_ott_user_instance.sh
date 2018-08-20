#!/bin/sh

echo "Deprecated, transfer to zsc."
exit 1

PATH_OTT=$HOME/svn/ott/cms/trunk
PATH_UAT=$HOME/svn/ott-uat

uat_modules=(
    "./ams/common/modules/User.php"
    "./track/common/modules/User.php"
    #"./app/common/modules/User.php"
    "./cs/common/modules/User.php"
    "./ott_redeem/common/modules/User.php"
    "./www/common/modules/User.php"
    "./cms/common/modules/User.php"
    "./track-cluster/common/modules/User.php"
    "./console/common/modules/User.php"
    )

uat_models=(
    "./www/frontendph/models/User.php"
    "./www/frontendsg/models/User.php"
    #"./www/frontend/models/User.php"
    "./www/frontendth/models/User.php"
    "./www/frontendall/models/User.php"
   )

sync() {
    local source="$1"
    local target=$2

    for f in ${target[*]}; do
        echo "$f ..."
        cp $source $f
        myexp
        echo
    done
    echo 
}

sync2() {
    local source="$1"
    local target=$2

    for f in ${target[*]}; do
        echo "$f ..."
        cp $source $f
        myexp
        echo

        flag=`echo $f | sed 's/.*frontend\([a-z]*\)\/.*/\1/g'`
        # mac 下特殊处理
        # -i 后要增加空字符串
        sed -i "" "s/namespace frontend/namespace frontend${flag}/g" $f
    done
    echo 
}

mycp() {
    local from="$1"
    local to="$2"

    echo "cp $2 ..."
    cp $from $to
    myexp
    echo
}

myrm() {
    local file="$1"

    echo "rm $file ..."
    if [ -f $file ]; then
        svn rm $file
    fi
    myexp
    echo
}

myexp() {
    if [ $? -eq 0 ]; then
        echo "+Ok"
    else
        echo "-Err"
    fi
}

## uat ##
echo ">> Sync uat evn <<"
cd $PATH_UAT

echo "Sync modules ..."
sync "./app/common/modules/User.php" "${uat_modules[*]}"

echo "Sync models ..."
sync2 "./www/frontend/models/User.php" "${uat_models[*]}"

## local ##
echo ">> Sync local evn <<"
cd $PATH_OTT

# common
mycp $PATH_UAT/app/common/modules/User.php ./common/modules/User.php
mycp $PATH_UAT/app/common/config/params-local.php ./common/config/params-local.php
mycp $PATH_UAT/app/common/config/params-local-qa.php ./common/config/params-local-qa.php
myrm ./common/models/cache/User.php
myrm ./common/models/db/User.php
myrm ./common/models/User.php

# app
mycp $PATH_UAT/app/api/controllers/UserController.php ./api/controllers/UserController.php
mycp $PATH_UAT/app/app/modules/v1/controllers/OperatorsController.php app/modules/v1/controllers/OperatorsController.php
mycp $PATH_UAT/app/app/modules/v1/controllers/TvController.php app/modules/v1/controllers/TvController.php
mycp $PATH_UAT/app/app/modules/v1/controllers/UserController.php app/modules/v1/controllers/UserController.php

# ams
mycp $PATH_UAT/ams/ams/models/User.php ./ams/models/User.php
mycp $PATH_UAT/ams/ams/controllers/PaymentController.php ams/controllers/PaymentController.php
mycp $PATH_UAT/ams/ams/controllers/UtilsController.php ams/controllers/UtilsController.php

# www
mycp $PATH_UAT/www/frontend/models/User.php ./frontend/models/User.php
mycp $PATH_UAT/www/frontend/controllers/UserController.php frontend/controllers/UserController.php
mycp $PATH_UAT/www/frontend/controllers/VodController.php frontend/controllers/VodController.php

mycp $PATH_UAT/www/frontendph/models/User.php ./frontendph/models/User.php
mycp $PATH_UAT/www/frontendph/controllers/HomeController.php frontendph/controllers/HomeController.php
mycp $PATH_UAT/www/frontendph/controllers/UserController.php frontendph/controllers/UserController.php
mycp $PATH_UAT/www/frontendph/controllers/VodController.php frontendph/controllers/VodController.php

mycp $PATH_UAT/www/frontendsg/models/User.php ./frontendsg/models/User.php
mycp $PATH_UAT/www/frontendsg/controllers/HomeController.php frontendsg/controllers/HomeController.php
mycp $PATH_UAT/www/frontendsg/controllers/UserController.php frontendsg/controllers/UserController.php
mycp $PATH_UAT/www/frontendsg/controllers/VodController.php frontendsg/controllers/VodController.php

mycp $PATH_UAT/www/frontendth/models/User.php ./frontendth/models/User.php



