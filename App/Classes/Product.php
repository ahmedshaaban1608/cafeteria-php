<?php
namespace App\Classes;
use PDO;
use App\Traits\ProductValidation;
use Exception;
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
      $result= $this->runDML("SELECT * FROM product where is_delete = false order by id desc;");
      return $result->fetchAll(PDO::FETCH_ASSOC);
  }
  public function countAll(){
    $result= $this->runDML("SELECT count(*) as 'count' FROM product where is_delete = false;");
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
    
    public function update($id){
        try {
            $this->runDML("UPDATE product SET name = '$this->name', price = $this->price, img = '$this->img' WHERE id=$id");
        }catch(Exception $e){
            return $e->getMessage();
        } 
    }
    
    public function updateStatus($id, $status){
        try {
            $this->runDML("UPDATE product SET is_available = $status WHERE id=$id");
        }catch(Exception $e){
            return $e->getMessage();
        } 
    }

    public function destroy($id){
        try {
            $this->runDML("UPDATE product SET is_delete = true WHERE id=$id");
        }catch(Exception $e){
            return $e->getMessage();
        } 
    }
    public function show($id){
        $result=$this->runDML("SELECT * FROM product WHERE id=$id");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
 
}