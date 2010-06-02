<?php

include(dirname(__FILE__).'/unit.php');
include(dirname(__FILE__).'/MyDoctrineTest.class.php');

class MyDoctrineTester
{
    private $myTest;
    final public function __construct($app)
    {
        $this->myTest = new MyDoctrineTest($app);
    }
    
    final public function run($t)
    {
        if(!($t instanceof lime_test || $t instanceof sfTestFunctional)){
            throw new Exception('run method argument is not instance of lime_test or sfTestFunctional.');
        }
        $lime_test = ($t instanceof sfTestFunctional) ? $t->test() : $t;
        $class_methods = get_class_methods($this);
        foreach($class_methods as $method_name){
            if(preg_match('/^.*Test\d*$/', $method_name)){
                $lime_test->diag($method_name.'() test');
                $this->myTest->loadData();
                try {
                    $this->$method_name($t);
                }catch(Exception $e){
                    $lime_test->fail($e);
                }
                $this->myTest->rollback();
            }
        }
    }
}
