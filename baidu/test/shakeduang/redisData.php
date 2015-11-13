#!/home/users/libo38/odp/php/bin/php
<?php
define('SHAKEDUANG', 61);

Bd_Init::init('memberapi');
$conf = Bd_Conf::getAppConf('/common/redis');

$userPreKey = $conf['points_uid_today']['KPRE'];
$srcPreKey = $conf['points_src_total']['KPRE'];

$args = getopt('u:s:');
if (empty($args['u'])) {
    $args['u'] = 1;
}
if (empty($args['s'])) {
    $args['s'] = SHAKEDUANG;
}

function help() {
    $file = basename(__FILE__);
    echo <<<HL
./$file [Options]
Options
    -u  会员id
    -s  积分来源id，默认61
HL;
}
function format($data) {
    return (empty($data)) ? '(nil)' : $data;
}

$today = date('Ymd');
$userKey = "${userPreKey}${today}_${args['s']}_${args['u']}";
$srcKey = "${srcPreKey}${today}_${args['s']}";

$redis = new Redis();
$redis->connect('localhost', '6379');
$user = format($redis->get($userKey));
$src = format($redis->get($srcKey));

echo "pass_uid[${args['u']}] points_src[${args['s']}] today[${today}]\n";
echo "member: ${user}\n";
echo "total: ${src}\n";

