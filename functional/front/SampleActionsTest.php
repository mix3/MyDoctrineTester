<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../bootstrap/MyDoctrineTester.class.php');

class MyTester extends MyDoctrineTester
{
    public function FooTest($b)
    {
        $b->test()->pass('FooTest passes.');
    }
    
    public function FooTest00($b)
    {
        $b->test()->pass('FooTest00 passes.');
    }
    
    public function FooTest01($b)
    {
        $b->test()->pass('FooTest01 passes.');
    }

    public function BarTest($b)
    {
        $b->test()->pass('BarTest passes.');
    }
    
    public function BarTest00($b)
    {
        $b->test()->pass('BarTest00 passes.');
    }
    
    public function BarTest01($b)
    {
        $b->test()->pass('BarTest01 passes.');
    }
}

$myTester = new MyTester('front');
$myTester->run(new sfTestFunctional(new sfBrowser()), $argv);
