<?php
  class Brand
{
    private $name;
    private $type;
    private $id;


    function __construct($name, $type, $id=null)
      {
        $this->name =$name;
        $this->type =$type;
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
      function getType()
      {
        return $this->type;
      }
      function setType($new_type)
      {
         $this->type = $new_type;
      }
      function getId()
      {
        return $this->id;
      }
      function save()
      {
        $executed = $GLOBALS['DB']->exec("INSERT INTO brands (name, type) VALUES ('{$this->getName()}', '{$this->getType()}'); ");
          if($executed){
            $this->id = $GLOBALS['DB']->lastInsertId();
            return true;
          }else{
          return false;
      }
    }
    static function getAll()
      {
        $brand = array();
        $returned_brands = $GLOBALS['DB']->query('SELECT * FROM brands;');
        foreach($returned_brands as $brands)
        {
          $newBrand = new Brand($brands['name'], $brands["type"],  $brands["id"]);
          array_push($brand, $newBrand);
        }
        return $brand;
      }
      static function deleteAll()
      {
        $executed = $GLOBALS['DB']->exec("DELETE FROM brands;");
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
      function addStore($store)
      {
        $executed = $GLOBALS['DB']->exec("INSERT INTO stores_brands (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        if ($executed){
          return true;
        }else{
          return false;
        }
      }
      function findStores()
      {
        $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN stores_brands ON (brands.id = stores_brands.brand_id)JOIN stores ON(stores_brands.store_id = stores.id) WHERE brand.id = {$this->getId()};");
        $stores = array();
        foreach($returned_stores as $store){
          $newStore = new Store($store['name'], $store['city'], $store['id']);
          array_push($stores, $newStore);
        }
        return $stores;
      }
      static function findBrandbyId($search_id)
      {
        $returned_brand = $GLOBALS['DB']->prepare("SELECT * FROM brands WHERE id = :id");
        $returned_brand->bindParam(':id', $search_id, PDO::PARAM_STR);
        $returned_brand->execute();
        foreach($returned_brand as $brand){
          $id = $brand['id'];
          if($id == $search_id){
            $newBrand = new Brand($brand['name'], $brand['type'], $brand['id']);
            return $newBrand;
          }
        }
    }
}
 ?>
