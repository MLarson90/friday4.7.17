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
         $this->name = (string)$new_name;
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
        $executed = $GLOBALS['DB']->exec("DELETE FROM stores;");
        if ($executed)
        {
          return false;
        }
        $executed = $GLOBALS['DB']->exec("DELETE FROM stores_brands;");
        if($executed){
          return false;
        }
        else {
          return true;
        }
      }
      function update_name($new_name){
        $executed = $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
        if($executed){
          $this->setName($new_name);
          return true;
        }else{
          return false;
        }
      }
      function delete()
      {
        $executed = $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        if ($executed){
          return false;
        }
        $executed = $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
        if($executed){
          return false;
        } else{
          return false;
         }
      }
      function addBrand($brand)
      {
        $executed = $GLOBALS['DB']->exec("INSERT INTO stores_brands (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        if ($executed){
          return true;
        }else{
          return false;
        }
      }
      function findBrands()
      {
        $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN stores_brands ON (stores_brands.store_id = stores.id)JOIN brands ON(brands.id = stores_brands.brand_id) WHERE stores.id = {$this->getId()};");
        $brands = array();
        foreach($returned_brands as $brand){
          $newBrand = new Brand($brand['name'], $brand['type'], $brand['id']);
          array_push($brands, $newBrand);
        }
        return $brands;
      }
      static function findStorebyId($search_id)
      {
        $returned_store = $GLOBALS['DB']->prepare("SELECT * FROM stores WHERE id = :id");
        $returned_store->bindParam(':id', $search_id, PDO::PARAM_STR);
        $returned_store->execute();
        foreach($returned_store as $store){
          $id = $store['id'];
          if($id == $search_id){
            $newStore = new Store($store['name'], $store['city'], $store['id']);
            return $newStore;
          }
        }
      }
}





 ?>
