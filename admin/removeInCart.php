<?php
session_start();
$id = $_GET['id'];
$product = [];
$product['id'] = $id;
$cart = [];
if(isset($_SESSION['cart'])){
$cart = $_SESSION['cart'];
}
$cart = array_filter($cart, function($product) use ($id) {
  return $product['id'] !== $id;
});
$_SESSION['cart'] = $cart;
header("Location: manual-order.php");
exit();
?>