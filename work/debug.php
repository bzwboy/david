<?php

use yii\helpers\ArrayHelper;

/**
 * 获取函数参数列表
 */
function x_getParams($method, $args) {
    echo $method, '()' . PHP_EOL;
    list($className, $methodName) = explode('::', $method);
    $refClass = new \ReflectionMethod($className, $methodName);
    $refParam = $refClass->getParameters();
    $tmp = [];
    array_walk($refParam, function($v) use($args, &$tmp) {
        static $id = 0;
        $av = ArrayHelper::getValue($args, $id++, null);
        $tmp['$' . $v->name] = $av;
    });
    print_r($tmp);
}

/**
 * sql 语句输出
 */
function x_sql_die($query, $file, $line)
{
    echo 'Location => '.$file . '(' . $line . ')' . PHP_EOL;
    echo $query->createCommand()->getRawSql();
    die;
}

