#!/usr/bin/env bash

#
# 手动merge 代码到其它分支
#

############################
FROM_BRANCH="lb_db_read1a"
COMMIT_MSG="upgrade db search to cluster"

FILES=(
        "main/application/controllers/v1/users.php"
     )
############################

to_branch=(
        "DevelopBranch"
        "qa"
        "master"
        "prod"
        )

indent="  "
base_dir="/Users/ott002/git/payment-backend"
tmp_dir="$HOME/tmp"

myexp() {
    if [ $? -ne 0 ]; then
        echo "-Err, cause error."
        exit $?
    fi
}

cd $base_dir

# step 1
echo "Copy file to tmp dir..."
git co $FROM_BRANCH 2>&1 | head -n 1
for i in ${FILES[@]}; do
    echo "${indent}> $i"
    cp $i $tmp_dir/`basename $i`
    myexp
done
echo -e "+Ok, succ\n"

# step 2
echo "Merge file to branch..."
for b in ${to_branch[@]}; do
    echo -n "* "

    git co $b 2>&1 | head -n 1
    echo "${indent}Update branch code"
    git pull > /dev/null 2>&1
    for i in ${FILES[@]}; do
        echo "${indent}> $i"
        cp $tmp_dir/`basename $i` $i
    done

    if [ $b == "DevelopBranch" ]; then
        git diff
        echo -n "${indent}Review code[Y/n]: "
        read flag
        if [ $flag != "Y" ]; then
            echo "+Ok, Terminate process."
            exit 1
        fi
    fi

    if [ "" == "`git st -s`" ]; then
        echo -e "${indent}Don't push anything!\n"
        continue
    fi

    git add . > /dev/null 2>&1
    myexp

    git ci -m "$COMMIT_MSG" 2>&1 | head -n 1
    myexp

    git push 2>&1 | tail -n 1
    myexp

    echo -e "${indent}+Ok, branch <$b>\n"
done
git co $FROM_BRANCH >/dev/null 2>&1
echo "+Ok, succ."
