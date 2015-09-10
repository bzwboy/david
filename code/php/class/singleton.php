<?php
class Singleton
{
    private static $inst;

    /**
     * 防止 new 
     * 
     * @return void
     * @throws em_exception
     */
    private function __construct()
    {
    }

    /**
     * 防止深度克隆 
     * 
     * @return void
     * @throws em_exception
     */
    private function __clone()
    {
    }

    /**
     * 防止 unserialize() 
     * 
     * @return void
     * @throws em_exception
     */
    private function __wakeup()
    {
    }

    /**
     * 防止 serialize() 
     * 
     * @return void
     * @throws em_exception
     */
    private function __sleep()
    {
    }

    /**
     * 唯一方法生成单例对象 
     * 
     * @return void
     * @throws em_exception
     */
    public static function getInstance()
    {
        if (!self::$inst) {
            self::$inst = new self();
        }

        return self::$inst;
    }
}

$a = Singleton::getInstance();
$b = Singleton::getInstance();
if ($a === $b) {
    echo "Same!\n";
} else {
    echo "Different!\n";
}

