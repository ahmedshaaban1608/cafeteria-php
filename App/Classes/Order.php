<?php
namespace App\Classes;
use Exception;
use PDO;

class Order extends Database{
  private $user_id, $status, $order_date, $notes, $room_no;
    public function _set($key, $value){
        if(property_exists($this,$key)){
            $value=htmlspecialchars(trim($value));
            $this->$key=$value;
        }
    }

    public function getAll(){
      $result= $this->runDML("SELECT * FROM orders_view;");
      return $result->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getAllProcessing(){
    $result= $this->runDML("SELECT * FROM orders_view where status = 'processing';");
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
  public function countAll(){
    $result= $this->runDML("SELECT count(*) as 'count' FROM product_order;");
    return $result->fetch(PDO::FETCH_ASSOC);
}
public function lastOrderId (){
  $result= $this->runDML("SELECT max(id) as id FROM product_order");
      return $result->fetch(PDO::FETCH_ASSOC);
}
  public function store(){
    try {
               
      $this->runDML("insert into product_order (user_id, notes, room_no) values ('$this->user_id', '$this->notes', $this->room_no)");
      return $this->lastOrderId();
  } catch(Exception $e){
      return $e->getMessage();
  } 
}
public function storeQuantity($orderId,$productId, $quantity){
  try {
      $this->runDML("insert into order_items (order_id, product_id, quantity) values ($orderId, $productId, $quantity)");
    return true;
} catch(Exception $e){
    return $e->getMessage();
} 
}
public function updateStatus($id,$status){
  $result= $this->runDML("update product_order set status = '$status' where id = $id;");
  return $result->fetchAll(PDO::FETCH_ASSOC);
}

public function show($id){
  $result= $this->runDML("SELECT * FROM orders_view where order_id = $id;");
  return $result->fetch(PDO::FETCH_ASSOC);
}
public function showOrderItems($id){
  $result= $this->runDML("SELECT p.name, p.price, i.quantity  FROM order_items i join product p on i.product_id = p.id  where i.order_id = $id;");
  return $result->fetchAll(PDO::FETCH_ASSOC);
}
}

