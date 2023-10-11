<?php
Session_start();
require_once '../vendor/autoload.php';
use App\Classes\Order;
if(isset($_POST['order_btn']) && $_SERVER["REQUEST_METHOD"] === "POST" ){
  $cart = $_SESSION['cart'];
  print_r($cart);
  echo '<br><br>';
  print_r($_POST);

  $userid = $_POST['userid'];
  $note = $_POST['note'];
  $room = $_POST['room'];
  if(empty($note)) $note = NULL;

  $order = new Order();
  $order->_set('user_id', $userid );
  $order->_set('notes', $note);
  $order->_set('room_no', $room );
  $result = $order->store();
  $orderId = $result['id'];
  if($result){
  foreach ($cart as $key => $product) {
    $productId = $product['id'];
  $quantity = $product['quantity'];
  $order->storeQuantity($orderId, $productId, $quantity);
  }
  unset($_SESSION['cart']);
  header("Location: index.php");
}
}
?>