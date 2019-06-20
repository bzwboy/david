<?php
$word = 'despise';
if (!empty($argv[1])) {
    $word = $argv[1];
}

$url = 'http://tv.baicizhan.com/search?keyword=' . $word;
$web = file_get_contents($url);

preg_match("|word_id=\"(\d+)\"|U", $web, $out);
if (empty($out)) {
    echo "word not exist!";
    exit(0);
}

$wid = $out[1];
$word_url = 'http://tv.baicizhan.com/videoWordInfo/';
$web = file_get_contents($word_url . $wid);
echo str_replace(' display: none;', 'margin-left:10px;', $web);

