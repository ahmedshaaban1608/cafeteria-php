<?php 
$id = $_GET['id'];

require_once "../vendor/autoload.php";
use App\Classes\Product;
$product = new Product();
$product->destroy($id);
header("Location: products.php");
exit();