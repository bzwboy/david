<?php
$arr = array('Zero', 'name'=>'Adil', 'address' => array( 'city'=>'Dubai', 'tel' => array('int' => 971, 'tel'=>12345487)), 'null' => 'nothing'); 

class MyArrIter extends RecursiveArrayIterator
{
    public function __construct($arr)
    {
        parent::__construct($arr);
    }

    public function getChildren()
    {
        echo "MyArrIter::getChildren\n";
        return parent::getChildren();
    }

    public function hasChildren()
    {
        echo 'MyArrIter::hasChildren = ', var_export(parent::hasChildren()), "\n";
        return parent::hasChildren();
    }
}

class MyIter extends RecursiveIteratorIterator
{
    public function __construct($arr)
    {
        parent::__construct(new MyArrIter($arr));
    }

    public function beginChildren()
    {
        echo "MyIter::beginChildren\n";
        parent::beginChildren();
    }

    public function beginIteration()
    {
        echo "MyIter::beginIteration\n";
        parent::beginIteration();
    }

    public function callGetChildren()
    {
        echo "MyIter::callGetChildren\n";
        return parent::callGetChildren();
    }

    public function callHasChildren()
    {
        echo "MyIter::callHasChildren\n";
        return parent::callHasChildren();
    }

    public function current()
    {
        echo "MyIter::current = ", parent::current(), "\n";
        return parent::current();
    }

    public function endChildren()
    {
        echo "MyIter::endChildren\n";
        parent::endChildren();
    }

    public function endIteration()
    {
        echo "MyIter::endIteration\n";
        parent::endIteration();
    }

    public function getSubIterator()
    {
        echo "MyIter::getSubIterator" . parent::getSubIterator(), "\n";
        return parent::getSubIterator();
    }

    public function key()
    {
        echo "MyIter::key = " . parent::key(), "\n";
        return parent::key();
    }

    public function next()
    {
        echo "MyIter::next\n";
        parent::next();
    }

    public function nextElement()
    {
        echo "MyIter::nextElement\n";
        parent::nextElement();
    }

    public function valid()
    {
        echo 'MyIter::valid = ', var_export(parent::valid()), "\n";
        return parent::valid();
    }
}

print_r($arr);
$iter = new MyIter($arr);
foreach ($iter as $k => $v) {
    echo "+++++++++++++++++++++\n";
    echo "$k => $v \n";
    echo "+++++++++++++++++++++\n";
}

