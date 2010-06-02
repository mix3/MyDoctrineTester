<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../bootstrap/MyDoctrineTester.class.php');

class MyTester extends MyDoctrineTester
{
    public function SampleTest($b)
    {
        $b->
            get('/mypage/index')->

            with('request')->begin()->
                isParameter('module', 'mypage')->
                isParameter('action', 'index')->
            end()->

            with('response')->begin()->
                isStatusCode(200)->
                checkElement('body', '!/This is a temporary page/')->
            end()
        ;
    }
    
    public function SampleTest00($b)
    {
        $b->
            get('/mypage/index')->

            with('request')->begin()->
                isParameter('module', 'mypage')->
                isParameter('action', 'index')->
            end()->

            with('response')->begin()->
                isStatusCode(200)->
                checkElement('body', '!/This is a temporary page/')->
            end()
        ;
    }
    
    public function SampleTest01($b)
    {
        $b->
            get('/mypage/index')->

            with('request')->begin()->
                isParameter('module', 'mypage')->
                isParameter('action', 'index')->
            end()->

            with('response')->begin()->
                isStatusCode(200)->
                checkElement('body', '!/This is a temporary page/')->
            end()
        ;
    }
}

$myTester = new MyTester('front');
$myTester->run(new sfTestFunctional(new sfBrowser()));
