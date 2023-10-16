<?php
require_once '../vendor/autoload.php';
use App\Classes\Order;
use App\Classes\User;
session_start();
if (isset($_SESSION['user'])) {
    $loggedUser = $_SESSION['user'];
    if ($loggedUser['type'] === 'user') {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
$order = new Order();
$user = new User();
$total_price = $order->totalPriceByUser();
$users = $user->getAll();
$user_id = 0;
$startingDate = 0;
$endingDate = 0;
if(isset($_POST['filter_btn']) && $_SERVER["REQUEST_METHOD"] === "POST" ){
  // print_r($_POST);

 
  if(isset($_POST['user'])){
    $user_id =  $_POST['user'];
} 
if(!empty($_POST['startingDate'])){
$startingDate = $_POST['startingDate'];
}
if(!empty($_POST['endingDate'])){
$endingDate = $_POST['endingDate'];
}
$total_price = $order->totalPriceByUser($user_id,$startingDate, $endingDate);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cafe Dashboard</title>
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico"/>
</head>

<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php require_once('includes/adminheader.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php require_once('includes/adminsidebar.php') ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white me-2">
                          <i class="mdi mdi-home"></i>
                        </span> Checks
                    </h3>
                </div>
<div class="row mb-5">
  <form action="" method="post" class="m-auto w-75">
<div class="form-group">
                        <label for="startingDate">startingDate </label>
                        <input type="date" class="form-control mb-2" id="startingDate"  name="startingDate" >
                      
                      </div>
                      <div class="form-group">
                        <label for="endingDate">endingDate </label>
                        <input type="date" class="form-control mb-2" id="endingDate"  name="endingDate" >
                      
                      </div>
                      <div class="form-group">
                        <label for="user">user</label>
                        <select class="form-control mb-2" id="user" name="user">
                          <option selected disabled>seelct user</option>
                          <?php foreach ($users as $userdata) {
                          echo "<option value='$userdata[id]'>$userdata[fullname]</option>";
                          
                          } ?>
                        </select>
            
                      </div>
                      <input type="submit" value="Filter" class="btn btn-primary" name="filter_btn">
  </form>
</div>

                <div class="row">
                    <div class="col-12 bg-white py-3 table-responsive">
                        <?php if(!empty($total_price)){?>
                          <div class="accordion" id="usersAccordion">
                            <?php 
                          
                            foreach ($total_price as $key => $usr) { ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="usersHeading<?php echo $key; ?>">
                                        <button class="accordion-button" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#usersCollapse<?php echo $key; ?>"
                                                aria-expanded="false"
                                                aria-controls="usersCollapse<?php echo $key; ?>">
                                            <div class="w-100 d-flex justify-content-between">
                                                <p><?php echo $usr['user_name']; ?></p>
                                                <p class="me-5"><?php echo $usr['total_price'] . ' EGP'; ?></p>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="usersCollapse<?php echo $key; ?>" class="accordion-collapse collapse"
                                         aria-labelledby="usersHeading<?php echo $key; ?>"
                                         data-bs-parent="#usersAccordion">
                                        <div class="accordion-body">
                                            <?php
                                            $ordersbyuser = $order->getAllByUser($usr['user_id'], $startingDate, $endingDate);
                                           
                                            foreach ($ordersbyuser as $orderKey => $orderValue) { ?>
                                                <div class="accordion" id="ordersAccordion<?php echo $key; ?>">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header"
                                                            id="ordersHeading<?php echo $key . '-' . $orderKey; ?>">
                                                            <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#orderCollapse<?php echo $key . '-' . $orderKey; ?>"
                                                                    aria-expanded="false"
                                                                    aria-controls="orderCollapse<?php echo $key . '-' . $orderKey; ?>">
                                                                <div class="w-100 d-flex justify-content-between">
                                                                    <p><?php echo $orderValue['order_date']; ?></p>
                                                                    <p class="me-5"><?php echo $orderValue['total_price'] . ' EGP'; ?></p>
                                                                </div>
                                                            </button>
                                                        </h2>
                                                        <div
                                                            id="orderCollapse<?php echo $key . '-' . $orderKey; ?>"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="ordersHeading<?php echo $key . '-' . $orderKey; ?>"
                                                            data-bs-parent="#ordersAccordion<?php echo $key; ?>">
                                                            <div class="accordion-body">
                                                                <h3 class="text-center my-4">Order Items</h3>
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Product name</th>
                                                                        <th>Item price</th>
                                                                        <th>Quantity</th>
                                                                        <th>SubTotal price</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $orderItems = $order->showOrderItems($orderValue['order_id']);
                                                                    foreach ($orderItems as $item) { ?>
                                                                        <tr>
                                                                            <td><?php echo $item['name']; ?></td>
                                                                            <td><?php echo $item['price']; ?></td>
                                                                            <td><?php echo $item['quantity']; ?></td>
                                                                            <td><?php echo ($item['quantity'] * $item['price']) . ' EGP'; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php } else {?>
                        <div class="text-center py-5 display-3">
                          No checks was found, try another filter
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../assets/vendors/js/vendor.bundle.base.js"></script>
<script src="../assets/vendors/chart.js/Chart.min.js"></script>
<script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="../assets/js/off-canvas.js"></script>
<script src="../assets/js/hoverable-collapse.js"></script>
<script src="../assets/js/misc.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/todolist.js"></script>
</body>
</html>
