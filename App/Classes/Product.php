<?php
namespace App\Classes;
use PDO;
use App\Traits\ProductValidation;

class Product extends Database{
    use ProductValidation;
    private $name,$price,$img;

    public function _set($key, $value){
        if(property_exists($this,$key)){
            $value=htmlspecialchars(trim($value));
            $this->$key=$value;
        }
    }

    public function getAll(){
      $result= $this->runDML("SELECT * FROM product;");
      return $result->fetchAll(PDO::FETCH_ASSOC);
  }
  public function countAll(){
    $result= $this->runDML("SELECT count(*) as 'count' FROM product;");
    return $result->fetch(PDO::FETCH_ASSOC);
}


    public function store(){
    
            try {
               
                $this->runDML("insert into product (name, price, img) values ('$this->name', $this->price, '$this->img')");
                return true;
            } catch(Exception $e){
                return $e->getMessage();
            } 
        }
    
    public function update($id){}
    public function destroy($id){
        try {
            $this->runDML("SELECT * FROM departments WHERE SSN=$id");
        }catch(Exception $e){
            return $e->getMessage();
        } 
    }
    public function show($id){
        $result=$this->runDML("SELECT * FROM product WHERE id=$id");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
 
}