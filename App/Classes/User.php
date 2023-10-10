<?php
namespace App\Classes;
use PDO;
use App\Traits\UserValidation;

class User extends Database{
    use UserValidation;
    private $fullname,$email,$hashed_password,$profile_img, $room_no, $ext;

    public function _set($key, $value){
        if(property_exists($this,$key)){
            $value=htmlspecialchars(trim($value));
            $this->$key=$value;
        }
    }

    public function getAll(){
      $result= $this->runDML("SELECT * FROM user;");
      return $result->fetchAll(PDO::FETCH_ASSOC);
  }
  public function countAll(){
    $result= $this->runDML("SELECT count(*) as 'count' FROM user;");
    return $result->fetch(PDO::FETCH_ASSOC);
}


    public function store(){
    
            try {
               
                $this->runDML("insert into user (fullname, email, hashed_password, profile_img, room_no, ext) values ('$this->fullname', '$this->email', '$this->hashed_password', '$this->profile_img', $this->room_no, $this->ext)");
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
        $result=$this->runDML("SELECT * FROM user WHERE Dno=$id");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function showByEmail($email){
        $result=$this->runDML("SELECT * FROM user WHERE email='$email'");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}