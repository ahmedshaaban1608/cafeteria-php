<?php
namespace App\Classes;
use PDO;
use Exception;
class Database{
    private $connection;

    public function __construct()
    {
        try{
            $this->connection=new PDO("mysql:host=localhost;dbname=cafe","root","");
        }catch(Exception $e){
            echo $e->getMessage();
        }  
    }

    public function runDML($stmt){
        try{
            return $this->connection->query($stmt);
        }catch(Exception $e){
            echo $e->getMessage();
        }  
   
    }   
}
