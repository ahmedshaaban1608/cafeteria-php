<?php 
$id = $_GET['id'];

require_once "../vendor/autoload.php";
use App\Classes\User;
$user = new User();
$user->destroy($id);
header("Location: users.php");
exit();