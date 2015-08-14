<?php
trait A {
    public function f1()
    {
        echo "A::f1()\n";
    }

    public function f2()
    {
        echo "A::f2()\n";
    }
}

trait B {
    public function f1()
    {
        echo "B::f1()\n";
    }

    public function f2()
    {
        echo "B::f2()\n";
    }
}

class T
{
    use A, B {
        A::f1 insteadof B;
        B::f2 insteadof A;
    }
}

$t = new t;
$t->f1();
$t->f2();

