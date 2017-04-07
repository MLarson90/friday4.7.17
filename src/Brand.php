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
        $deleteAll = $GLOBALS['DB']->exec("DELETE FROM brands;");
        if ($deleteAll)
        {
          return true;
        }else {
          return false;
        }
      }
    }

 ?>
