<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

$DB = new PDO('mysql:host=localhost:8889;dbname=shoes_test', "root", "root");
require_once "src/Brand.php";
require_once "src/Store.php";
class SampleTest extends PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    Brand::deleteAll();
    Store::deleteAll();

  }
    function test_Save()
    {
      $newStore = new Store ("max", "blue");
      $newStore->save();
      $result = Store::getAll();
      $this->assertEquals($result, [$newStore]);
    }

    function test_deleteAll()
    {
      $newClass = new Store ("max","blue");
      $newClass->save();
      Store::deleteAll();
      $result = Store::getAll();
      $this->assertEquals($result, []);
    }
    function test_getAll()
    {
      $newClass = new Store ('max', 'blue');
      $newClass2 = new Store ('jack', "black");
      $newClass->save();
      $newClass2->save();
      $result = Store::getAll();
      $this->assertEquals($result, [$newClass, $newClass2] );
    }
  }






?>
