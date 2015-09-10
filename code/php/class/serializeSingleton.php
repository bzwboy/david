<?php
/**
 * 可序列化的单例模式 
 * 
 * @copyright  Copyright (C) 2008-2015 Minnesota David
 * @author     libo <libo@eyou.net>
 * @package    Product
 * @see http://www.laruence.com/2011/03/18/1916.html
 * @see http://www.laruence.com/2008/09/19/520.html
 */
class Singleton
{
    private static $inst;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * unserialize(); 
     * 
     * @return void
     * @throws Exception
     */
    public function __wakeup()
    {
        self::$inst = $this;
    }

    public function getInstance()
    {
        if (!self::$inst) {
            self::$inst = new self();
        }

        return self::$inst;
    }
}

/**
 * 仔细考虑输出对象最终变为#2
 *
 * 代码输出：
 * object(Singleton)#1 (0) {
 * }
 * Singleton::__wakeup
 *
 * object(Singleton)#2 (0) {
 * }
 * object(Singleton)#2 (0) {
 * }
 * bool(true)
 *
 * 
 * @return void
 */
function test_1()
{
    $inst = Singleton::getInstance();
    echo "\$inst is:\n";
    var_dump($inst);
    echo "\n";

    $seri = serialize($inst);
    echo "serialize result:\n";
    var_dump($seri);
    echo "\n";

    $obj = unserialize($seri);
    echo "unserialize result:\n";
    var_dump($obj);
    echo "\n";

    echo "Singleton::getInstance()\n";
    var_dump(Singleton::getInstance());
    echo "\n";

    if ($obj === Singleton::getInstance()) {
        echo "multi object is same.\n";
    } else {
        echo "multi object is different.\n";
    }
}

/**
 * test_2 
 * 
 * @return void
 * @throws Exception
 */
function test_2()
{
    $a = Singleton::getInstance();
    echo "\$a is:\n";
    var_dump($a);
    echo "\n";

    $a = unserialize(serialize($a));
    echo "\$a after serialize/unserialize is:\n";
    var_dump($a);
    echo "\n";

    echo "Singleton::getInstance():\n";
    var_dump(Singleton::getInstance());
    echo "\n";

    echo "\$a === Singleton::getInstance()\n";
    var_dump($a === Singleton::getInstance());
}

test_2();
