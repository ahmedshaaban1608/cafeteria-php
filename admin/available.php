<?php 
$id = $_GET['id'];
$status = $_GET['status'];

require_once "../vendor/autoload.php";
use App\Classes\Product;
$product = new Product();
$product->updateStatus($id, $status);
header("Location: products.php");
exit();