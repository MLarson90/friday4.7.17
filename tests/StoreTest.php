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
      $newStore = new Store ("max","blue");
      $newStore->save();
      Store::deleteAll();
      $result = Store::getAll();
      $this->assertEquals($result, []);
    }
    function test_getAll()
    {
      $newStore = new Store ('max', 'blue');
      $newStore2 = new Store ('jack', "black");
      $newStore->save();
      $newStore2->save();
      $result = Store::getAll();
      $this->assertEquals($result, [$newStore, $newStore2] );
    }
    function test_update_name()
    {
      $newStore = new Store ("max","blue");
      $newStore->save();
      $newStore->update_name("Steve");
      $result = $newStore->getName();
      $this->assertEquals("Steve", $result);
    }
    function test_find_by_id()
    {
      $newStore = new Store ('max', 'blue');
      $newStore2 = new Store ('jack', "black");
      $newStore->save();
      $newStore2->save();
      $test= $newStore->getId();
      $result = Store::findStorebyId($test);
      $this->assertEquals($newStore, $result);
    }
  }






?>
