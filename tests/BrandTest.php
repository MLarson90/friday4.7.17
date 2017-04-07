<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

$DB = new PDO('mysql:host=localhost:8889;dbname=shoes_test', "root", "root");
require_once "src/Brand.php";
require_once "src/Store.php";
class Sample2Test extends PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    Brand::deleteAll();
    Store::deleteAll();
  }
  function test_Save()
  {
    $newClass = new Brand ("max", "blue");
    $newClass->save();
    $result = Brand::getAll();
    $this->assertEquals($result, [$newClass]);
  }
  function test_deleteAll()
  {
    $newClass = new Brand ("max","blue");
    $newClass->save();
    Brand::deleteAll();
    $result = Brand::getAll();
    $this->assertEquals($result, []);
  }
  function test_getAll()
  {
    $newClass = new Brand ('max', 'blue');
    $newClass2 = new Brand ('jack', "black");
    $newClass->save();
    $newClass2->save();
    $result = Brand::getAll();
    $this->assertEquals($result, [$newClass, $newClass2] );
  }
}






?>
