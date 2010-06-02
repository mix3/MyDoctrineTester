<?php

include(dirname(__FILE__).'/../../bootstrap/MyDoctrineTester.class.php');

class MyTester extends MyDoctrineTester
{
    public function SampleTest($t)
    {
        $t->pass('This test always passes.');
    }
    
    public function SampleTest00($t)
    {
        $t->pass('This test always passes.');
    }
    
    public function SampleTest01($t)
    {
        $t->pass('This test always passes.');
    }
}

$myTester = new MyTester('front');
$myTester->run(new lime_test());
