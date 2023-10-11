<?php
namespace App\Classes;
use PDO;
use App\Traits\UserValidation;
use Exception;
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
      $result= $this->runDML("SELECT * FROM user where type = 'user';");
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
    
    public function update($id){
        try {
               
            $this->runDML("UPDATE user SET fullname = '$this->fullname', profile_img = '$this->profile_img', room_no = $this->room_no, ext =  $this->ext WHERE id = $id");
            return true;
        } catch(Exception $e){
            return $e->getMessage();
        } 
    }
    public function destroy($id){
        try {
            $this->runDML("DELETE FROM user WHERE id=$id");
        }catch(Exception $e){
            return $e->getMessage();
        } 
    }
    public function show($id){
        $result=$this->runDML("SELECT * FROM user WHERE id=$id");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function showByEmail($email){
        $result=$this->runDML("SELECT * FROM user WHERE email='$email'");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}