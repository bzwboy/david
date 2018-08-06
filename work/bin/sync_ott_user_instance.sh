#!/bin/sh

cd /Users/ott002/svn/ott-uat

modules=(
    "./ams/common/modules/User.php"
    "./track/common/modules/User.php"
    #"./app/common/modules/User.php"
    "./cs/common/modules/User.php"
    "./ott_redeem/common/modules/User.php"
    "./www/common/modules/User.php"
    "./cms/common/modules/User.php"
    "./track-cluster/common/modules/User.php"
    "./ccs/common/models/User.php"
    "./console/common/modules/User.php"
    )

models=(
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
        echo "==> $f <=="
        cp $source $f
        if [ $? == 0 ]; then
            echo "+Ok"
        fi
    done
    echo 
}

echo "Sync modules/User.php ..."
sync "./app/common/modules/User.php" "${modules[*]}"

echo "Sync models/User.php ..."
sync "./www/frontend/models/User.php" "${models[*]}"

