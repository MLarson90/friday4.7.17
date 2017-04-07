<?php
  class Store
{
    private $name;
    private $city;
    private $id;


    function __construct($name, $city, $id=null)
      {
        $this->name =$name;
        $this->city =$city;
        $this->id = $id;
      }
      function getName()
      {
        return $this->name;
      }
      function setName($new_name)
      {
         $this->name = $new_name;
      }
      function getCity()
      {
        return $this->city;
      }
      function setCity($new_city)
      {
         $this->city = $new_city;
      }
      function getId()
      {
        return $this->id;
      }
      function save()
      {
        $executed = $GLOBALS['DB']->exec("INSERT INTO stores (name, city) VALUES ('{$this->getName()}', '{$this->getCity()}'); ");
          if($executed){
            $this->id = $GLOBALS['DB']->lastInsertId();
            return true;
          }else{
          return false;
          }
      }
    static function getAll()
      {
        $stores = array();
        $returned_store = $GLOBALS['DB']->query('SELECT * FROM stores;');
        foreach($returned_store as $store){
          $newStore = new Store($store['name'], $store["city"],  $store["id"]);
          array_push($stores, $newStore);
        }
          return $stores;
      }
      static function deleteAll()
      {
        $deleteAll = $GLOBALS['DB']->exec("DELETE FROM stores;");
        if ($deleteAll)
        {
          return true;
        }else {
          return false;
        }
      }
}





 ?>
