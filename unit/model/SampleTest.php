<?php

include(dirname(__FILE__).'/../../bootstrap/MyDoctrineTester.class.php');

class MyTester extends MyDoctrineTester
{
    public function Test($t)
    {
        $t->pass('FooTest passes.');
    }
    
    public function FooTest($t)
    {
        $t->pass('FooTest passes.');
    }
    
    public function FooTest00($t)
    {
        $t->pass('FooTest00 passes.');
    }
    
    public function FooTest01($t)
    {
        $t->pass('FooTest01 passes.');
    }
    
    public function BarTest($t)
    {
        $t->pass('BarTest passes.');
    }
    
    public function BarTest00($t)
    {
        $t->pass('BarTest00 passes.');
    }
    
    public function BarTest01($t)
    {
        $t->pass('BarTest01 passes.');
    }
}

$myTester = new MyTester('front');
$myTester->run(new lime_test(), $argv);
