<?php
session_start();
$id = $_GET['id'];
$name = $_GET['name'];
$price = $_GET['price'];
$product = [];
$product['id'] = $id;
$product['name'] = $name;
$product['price'] = $price;
$product['quantity'] = 1;
$cart = [];
if(isset($_SESSION['cart'])){
$cart = $_SESSION['cart'];
}
array_push($cart,$product);
$_SESSION['cart'] = $cart;
header("Location: manual-order.php");
exit();
?>