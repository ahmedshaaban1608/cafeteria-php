<?php
  session_start();
  require_once 'vendor/autoload.php';
  use App\Classes\User;
if(isset($_POST['register-btn']) && $_SERVER["REQUEST_METHOD"] === "POST" ){

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$room = $_POST['room'];
$ext = $_POST['ext'];


  // uploaded file
  $f_name = $_FILES['img']['name'];
  $f_size = $_FILES['img']['size'];
  $f_path = $_FILES['img']['tmp_name'];
  $type_arr = explode(' ','jpg png jpeg webp gif');

  $user = new User();
  $is_name = $user->validateFullName($name);
  $is_email = $user->validateEmail($email);
  $is_password = $user->validatePass($password) && $password === $confirm_password;
  $is_room = $user->validateNumber($room);
  $is_ext = $user->validateNumber($ext);
  $is_img = $user->fileValidator($f_name, $type_arr, $f_size, '2097152');

  $error_arr = [];
  if(!$is_name) $error_arr['name']='invalid name';
   if (!$is_email) $error_arr['email']='invalid email';
  if (!$is_password) $error_arr['password']="password must be more than 8 characters, letters and numbers only";
  if($confirm_password !== $password) $error_arr['confirm_password']='password and confirm password must be the same';
  if (!$is_room) $error_arr['room']='invalid room number';
  if (!$is_ext) $error_arr['ext']='invalid ext number';
  if(!$is_img) $error_arr['img']='must be a vaild image with size less than 2 MB';
    
  // redirect me if there is an error
  if(count($error_arr)){
  
    $_SESSION['register_errors'] = $error_arr;
    header("Location: register.php");
    exit();
  }
  $img_path = 'assets/uploads/'.(time() - 1696070596).$f_name;
  move_uploaded_file($f_path, $img_path);

$user->_set('fullname',$name);
$user->_set('email',$email);
$user->_set('hashed_password',md5($password));
$user->_set('room_no',$room);
$user->_set('ext',$ext);
$user->_set('profile_img','/cafe/'.$img_path);

$result = $user->store();
if($result === true){
  $_SESSION['user'] = $user->showByEmail($email);
  header("Location: index.php");
  exit();
}
} else {
  header("Location: login.php");
  exit();
}
?>