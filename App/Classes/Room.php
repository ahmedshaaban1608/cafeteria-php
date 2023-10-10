<?php
namespace App\Classes;
use PDO;

class Room extends Database{
    public function _set($key, $value){
        if(property_exists($this,$key)){
            $value=htmlspecialchars(trim($value));
            $this->$key=$value;
        }
    }

    public function getAll(){
      $result= $this->runDML("SELECT * FROM room;");
      return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}