<?php
  session_start();
  require_once '../vendor/autoload.php';
  use App\Classes\Product;
if(isset($_POST['product-btn']) && $_SERVER["REQUEST_METHOD"] === "POST" ){

$name = $_POST['name'];
$price = $_POST['price'];


  // uploaded file
  $f_name = $_FILES['img']['name'];
  $f_size = $_FILES['img']['size'];
  $f_path = $_FILES['img']['tmp_name'];
  $type_arr = explode(' ','jpg png jpeg webp gif');

  $product = new Product();
  $is_name = $product->validateName($name);
  $is_price = $product->validateNumber($price);
  $is_img = $product->fileValidator($f_name, $type_arr, $f_size, '2097152');

  $error_arr = [];
  if(!$is_name) $error_arr['name']='invalid name';
   if (!$is_price) $error_arr['price']='invalid price number';
  if(!$is_img) $error_arr['img']='must be a vaild image with size less than 2 MB';
    
  // redirect me if there is an error
  if(count($error_arr)){
  
    $_SESSION['product_errors'] = $error_arr;
    header("Location: products.php");
    exit();
  }
  move_uploaded_file($f_path, '/cafe/assets/uploads/'.(time() - 1696070596).$f_name);

$product->_set('name',$name);
$product->_set('price',$price);
$product->_set('img','/cafe/assets/uploads/'.(time() - 1696070596).$f_name);

$product->store();
header("Location: products.php");
}
?>