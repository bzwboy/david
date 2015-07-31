<?php
abstract class T1
{
    // 可以避免直接生成 T2 对象
    final private function __construct() 
    {
    }

    final public static function getInstance()
    {
        // wrong
        // 语法检查不会出错，运行时报错
        // PHP Fatal error:  Call to undefined method T2::self()
        #return static::self(); 

        // right
        // delay bound
        return new static();
    }
}

class T2 extends T1
{
    // wrong
    // Fatal error: Cannot override final method T1::__construct()
    #public function __construct($msg)
    #{
    #    echo "$msg\n";
    #}

    public function hello()
    {
        echo "Hello World\n";
    }
}

// wrong
// PHP Fatal error:  Call to private T1::__construct() from invalid context
#$t = new T2("libo");

// right
#$t1 = T2::getInstance();
#$t1->hello();
#var_dump('class: ' . get_class($t1));

