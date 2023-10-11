<?php
session_start();
$id = $_GET['id'];
$quantity = $_GET['quantity'];
echo $quantity ;
if(isset($_SESSION['cart'])){
$cart =$_SESSION['cart'];
foreach ($cart as &$p) {
  if ($p['id'] == $id) {
    $p['quantity'] = $quantity;
    break;
}
}
$_SESSION['cart'] = $cart;

}
header("Location: index.php");
exit();