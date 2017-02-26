<?php
$path = '/tmp/libo/gangliaxml_?filter=summary';
$ret = array();
$c = 10;

// method1
$t1 = microtime(true);
function xml_start($parser, $name, $attr) {
    global $ret;

    if ('METRICS' === $name) {
        $k = $attr['NAME'];
        unset($attr['NAME']);
        $ret[$k] = $attr;
    }
}

function xml_end($parser, $name) {
}

for ($i = 0; $i < $c; $i++) {
    $parser = xml_parser_create();
    xml_set_element_handler($parser, 'xml_start', 'xml_end');
    $fp = fopen($path, 'r');
    while (!feof($fp)) {
        $data = fread($fp, 16*1024);
        xml_parse($parser, $data, feof($fp));
    }
    fclose($fp);
}

//var_export($ret);
echo "1: ", microtime(true)-$t1, "\n";

// method2
$t1 = microtime(true);
function parse($path) {
    global $ret;

    return parseHelper(new SimpleXmlIterator($path, null, true));
}
function parseHelper($iter) {
    global $ret;

    foreach($iter as $key => $val) {
        if ('METRICS' === $key) {
            $attr = (array) $val->attributes();
            $attr = $attr['@attributes'];
            $k = $attr['NAME'];
            unset($attr['NAME']);
            $ret[$k] = $attr;
        } else {
            if ($iter->hasChildren()) {
                call_user_func(__FUNCTION__, $val);
            }
        }
    }
}

for ($i = 0; $i < $c; $i++) {
    parse($path);
}

//var_export($ret);
echo "2: ", microtime(true)-$t1, "\n";

