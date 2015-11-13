#!/home/users/libo38/odp/php/bin/php
<?php
# redis read/write test
#
# 测试结论：
# 1、读/写第一次需要3ms左右，以后需要100us
# 2、复用了连接socket，导致以后会很快
#
# 测试结果：
# 本机测试 redis 读/写时间，单位：微秒
# write: 3362 us
# read: 144 us
#
# 本机测试 redis 读/写时间，单位：微秒
# write: 121 us
# read: 125 us
#
# 本机测试 redis 读/写时间，单位：微秒
# write: 123 us
# read: 124 us
#
# 本机测试 redis 读/写时间，单位：微秒
# write: 119 us
# read: 122 us
#
# 本机测试 redis 读/写时间，单位：微秒
# write: 119 us
# read: 121 us

Bd_Init::init('memberapi');

$timer = new Bd_Timer(false, Bd_Timer::PRECISION_US);
for($i = 0, $c = 10; $i < $c; $i++) {
    $timer->start();
    $redis = new Redis;
    $redis->connect('localhost', 6379);
    $ret = $redis->set('name', 'libo' . $i);
    $redis->close();
    unset($redis);
    $setTime = $timer->stop();

    usleep(10000);

    $timer->start();
    $redis = new Redis;
    $redis->connect('localhost', 6379);
    $ret = $redis->get('name');
    $redis->close();
    unset($redis);
    $getTime = $timer->stop();

    echo <<<RE
\n本机测试 redis 读/写时间，单位：微秒
write: $setTime us
read: $getTime us\n
RE;
}
