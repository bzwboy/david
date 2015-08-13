<?php
#
# 深度复制 clone
#

class T1
{
    private $__t2;

    public function __construct()
    {
        $this->__t2 = new T2();
    }

    public function get()
    {
        return $this->__t2;
    }

    public function __clone()
    {
        $this->__t2 = clone $this->__t2;
    }
}

class T2 {}

$t1 = new T1;
$t11 = clone $t1;

var_dump($t1);
var_dump($t11);

