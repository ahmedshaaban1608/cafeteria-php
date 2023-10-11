<?php
Session_start();
require_once '../vendor/autoload.php';
use App\Classes\Order;
$id = $_GET['id'];
$order = new Order();
$order->updateStatus($id, 'done');
header("Location: index.php");