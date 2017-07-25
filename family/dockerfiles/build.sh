#!/bin/sh

#
# 构建 nmpr 环境
#

# Setting
image_mysql="libo/mysql"
image_nginx="libo/nginx"
image_php="libo/php"
# End

cd /home/libo/git/david/family/dockerfiles
myexp() {
    if [ $? -ne 0 ]; then
        echo -e "-Err\n"
        exit $?
    fi
}

### mysql ###
#docker build -t $image_mysql ./mysql
#docker run -p 3306:3306 -v ~/opt/data/mysql:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=123456 -d $image_mysql

### nginx ###
# clean
#echo "clean docker container"
#docker rm $(docker ps -a |grep $image_nginx |awk '{print $1}')
#echo "clean docker image"
#docker rmi $(docker images |grep $image_nginx |awk '{print $3}')
#echo -e "+Ok\n"
#sleep 2
#
#echo "start build image..."
#docker build -t $image_nginx ./nginx
#echo -e "pause...\n"
#sleep 2
#
#echo "run image..."
#sudo mkdir -p ~/opt/log/nginx
#sudo docker run -p 8091:8091 -v ~/opt:/opt -d $image_nginx


### php ###
# clean
echo "clean docker container"
docker rm $(docker ps -a |grep "$image_php " |awk '{print $1}')
echo "clean docker image"
docker rmi $(docker images |grep "$image_php " |awk '{print $3}')
echo -e "+Ok\n"
sleep 2

echo -e "build php image..."
docker build -t $image_php ./php
myexp
sleep 2

echo -e "run php image..."
sudo mkdir -p ~/opt/log/php
docker run -p 9000:9000 -v ~/opt:/opt -d $image_php
myexp

