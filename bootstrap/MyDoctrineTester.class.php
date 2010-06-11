<?php

include(dirname(__FILE__).'/unit.php');
include(dirname(__FILE__).'/MyDoctrineTest.class.php');

class MyDoctrineTester
{
    protected $myTest;
    private $stack;
    final public function __construct($app)
    {
        $this->myTest = new MyDoctrineTest($app);
        $this->stack = array();
    }
    
    final public function run($t, $argv = null)
    {
        // テストクラス lime_test か、sfTestFunctional 以外は弾く
        if(!($t instanceof lime_test || $t instanceof sfTestFunctional)){
            throw new Exception('run method argument is not instance of lime_test or sfTestFunctional.');
        }
        
        // diag表時用の変数を生成
        $lime_test = ($t instanceof sfTestFunctional) ? $t->test() : $t;
        
        // メソッド名抽出
        $class_methods = get_class_methods($this);
        
        // 引数に -l が含まれていたらテストメソッドを一覧表示して終了
        if($argv){
            foreach($argv as $v){
                if($v === '-l'){
                    foreach($class_methods as $method_name){
                        if(preg_match('/^.*Test\d*$/', $method_name)){
                            $lime_test->diag($method_name);
                        }
                    }
                    exit;
                }
            }
        }
        
        // テストの実行
        if(!$argv || count($argv) == 1){
            // 引数がnull、もしくは引数が無い場合は全テスト実行
            $this->execute($t, $lime_test, $class_methods);
        }else{
            // 引数が指定されている場合は、その名前のテストを実行
            $this->executeByArgv($t, $lime_test, $class_methods, $argv);
        }
    }
    
    final private function execute($t, $lime_test, $class_methods)
    {
        foreach($class_methods as $method_name){
            if(preg_match('/^.+Test\d*$/', $method_name)){
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
    
    final private function executeByArgv($t, $lime_test, $class_methods, $argv)
    {
    
        for($i = 1; $i < count($argv); $i++){
            // 名前の形によってテストする範囲を変える
            if(preg_match('/^.+Test\d+$/', $argv[$i])){
                // Test\d+ まで指定された場合はそれだけをテストする
                $method_name = $argv[$i];
                $lime_test->diag($method_name.'() test');
                $this->myTest->loadData();
                try {
                    $this->$method_name($t);
                }catch(Exception $e){
                    $lime_test->fail($e);
                }
                $this->myTest->rollback();
            }else{
                // そうでなければ、前方一致でテストする
                foreach($class_methods as $method_name){
                    if(preg_match("/^$argv[$i].*Test\d*$/", $method_name)){
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
    }
    
    final public function beginTransaction($name_space = null)
    {
        if($name_space == null){
            $name_space = self::getRandomString(32);
        }
        $this->myTest->beginTransaction($name_space);
        array_push($this->stack, $name_space);
    }
    
    final public function rollback($name_space = null)
    {
        if($name_space == null){
            $name_space = array_pop($this->stack);
        }
        $this->myTest->rollback($name_space);
    }
    
    final private static function getRandomString($nLengthRequired = 8){
        $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
        mt_srand();
        $sRes = "";
        for($i = 0; $i < $nLengthRequired; $i++){
            $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
        }
        return $sRes;
    }
}
