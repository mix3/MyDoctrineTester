使い方
=====

*****

Unit Test
---------

### テストクラス ###

<div style="color: blue;">$cat unit/model/SampleTest.php</div>
<pre>
&lt;?php

<span style="color: red;">// MyDoctrineTester.class.phpをincludeする。</span>
include(dirname(__FILE__).'/../../bootstrap/MyDoctrineTester.class.php');

<span style="color: red;">// MyDoctrineTesterを継承する</span>
class MyTester extends MyDoctrineTester
{
<span style="color: red;">
    /**
     * テストを書く　メソッド名が『<span style="color: blue;">/^.*Test\d*$/</span>』となるものがテスト実行の対象
     */
</span>
    public function <span style="color: green;">FooTest</span>($t)
    {
        $t->pass('FooTest passes.');
    }
    
    public function <span style="color: green;">FooTest</span><span style="color: red;">00</span>($t)
    {
        $t->pass('FooTest00 passes.');
    }
    
    public function <span style="color: green;">FooTest</span><span style="color: red;">01</span>($t)
    {
        $t->pass('FooTest01 passes.');
    }
    
    public function <span style="color: green;">BarTest</span>($t)
    {
        $t->pass('BarTest passes.');
    }
    
    public function <span style="color: green;">BarTest</span><span style="color: red;">00</span>($t)
    {
        $t->pass('BarTest00 passes.');
    }
    
    public function <span style="color: green;">BarTest</span><span style="color: red;">01</span>($t)
    {
        $t->pass('BarTest01 passes.');
    }
}

<span style="color: red;">// アプリ名を指定してテストクラスのインスタンスを取得</span>
$myTester = new MyTester(<span style="color: blue;">'front'</span>);

<span style="color: red;">// lime_testのインスタンスとコマンドライン引数を指定して、テストを実行する</span>
$myTester->run(<span style="color: blue;">new lime_test(), $argv</span>);
</pre>



### 実行 ###

#### そのまま実行すると全てのテストを実行する。 ####
<div style="color: blue;">$php unit/model/SampleTest.php</div>
<pre>
# FooTest() test
ok 1 - FooTest passes.
# FooTest00() test
ok 2 - FooTest00 passes.
# FooTest01() test
ok 3 - FooTest01 passes.
# BarTest() test
ok 4 - BarTest passes.
# BarTest00() test
ok 5 - BarTest00 passes.
# BarTest01() test
ok 6 - BarTest01 passes.
1..6
# Looks like everything went fine. 
</pre>


#### 引数を指定する事で、前方一致でヒットするテストのみ実行することが出来ます。####
<div style="color: blue;">$php unit/model/SampleTest.php <span style="color: red;">Foo</span></div>
<pre>
# FooTest() test
ok 1 - FooTest passes.
# FooTest00() test
ok 2 - FooTest00 passes.
# FooTest01() test
ok 3 - FooTest01 passes.
1..3
# Looks like everything went fine. 
</pre>


#### ただし、テスト対象を /^引数.Test\d*/ としているので、SampleTestのテストをするつもりで『SampleT』『SampleTest』などを指定するとテスト対象を探せません。 ####
<pre>
<span style="color: blue;">$php unit/model/SampleTest.php <span style="color: red;">FooT</span></span>
# Looks like everything went fine. 
<span style="color: blue;">$php unit/model/SampleTest.php <span style="color: red;">FooTest</span></span>
# Looks like everything went fine. 
</pre>


#### 数字まで指定（/^引数.+Test\d+$/に一致）すると完全一致でヒットするものだけをテストします ####
<div style="color: blue;">php unit/model/SampleTest.php <span style="color: red;">FooTest00</span></div>
<pre>
# FooTest00() test
ok 1 - FooTest00 passes.
1..1
# Looks like everything went fine. 
</pre>


*****

Functional Test
---------------

### テストクラス ###

<div style="color: blue;">$cat functional/front/SampleActionsTest.php</div>
<pre>
&lt;?php

<span style="color: red;">// functional.phpのincludeを忘れない</span>
include(dirname(__FILE__).'/../../bootstrap/functional.php');
<span style="color: red;">// MyDoctrineTester.class.phpをincludeする。</span>
include(dirname(__FILE__).'/../../bootstrap/MyDoctrineTester.class.php');

class MyTester extends MyDoctrineTester
{
<span style="color: red;">
    /**
     * テストを書く　命名規則等UnitTestと同じ。
     */
</span>
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

<span style="color: red;">// アプリ名を指定してテストクラスのインスタンスを取得</span>
$myTester = new MyTester(<span style="color: blue;">'front'</span>);

<span style="color: red;">// sfTestFunctionalのインスタンスと、コマンドライン引数を指定して、テストを実行する</span>
$myTester->run(<span style="color: blue;">new sfTestFunctional(new sfBrowser()), $argv</span>);
</pre>


### 実行 ###

#### Unit Test を参照 Unit Test と同じ。 ####


その他
-----

MyDoctrineTesterはsymfonyのテストを想定しています。以下のようにしてsymfonyのテストを実行することが出来ます。

<pre>
$./symfony tset:unit
$./symfony test:functional front
</pre>
