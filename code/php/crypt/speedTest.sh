#!/bin/sh

#
# 性能测试
#

count=100
for i in $(seq $count); do
    # real    0m15.078s
    # user    0m12.325s
    # sys     0m2.691s
    php ./mcrypt.php >/dev/null

    # real    0m15.056s
    # user    0m12.197s
    # sys     0m2.788s
    # php ./mcrypt_2.php >/dev/null
done
