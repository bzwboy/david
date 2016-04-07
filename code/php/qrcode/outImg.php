<?php
set_time_limit(0);

include('phpqrcode/phpqrcode.php'); 

$module = 'hangzhou-3';
$base = '/home/users/libo38/snapshot/test/apollo/xiaoxu';
$csv = "{$base}/publish/{$module}/hz-3-5.csv";
$imgPath = "{$base}/qrcode/{$module}";

$csvArr = file($csv);
for ($i = 0, $c = count($csvArr); $i < $c; $i++) {
    if ($i === 0) {
        continue;
    }

    $arr = explode(',', trim($csvArr[$i]));
    outImg($arr[0], $arr[1]);
    echo "+Ok, {$i} {$arr[0]}\n";
}


function outImg($data, $filename)
{
    global $imgPath;

    $filename = "{$imgPath}/{$filename}.png";

    // 二维码数据 
    //$data = 'http://band.baidu.com/naserver/common/qrcode?id=110'; 
    // 生成的文件名 
    //$filename = iconv('utf8','gb2312',$filename); 
    // 纠错级别：L、M、Q、H 
    $errorCorrectionLevel = 'L'; 
    // 点的大小：1到10 
    $matrixPointSize = 12; 

    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
}

