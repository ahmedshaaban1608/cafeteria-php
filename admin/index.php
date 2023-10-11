<?php
 session_start();
 require_once '../vendor/autoload.php';
use App\Classes\User;
use App\Classes\Product;
use App\Classes\Order;
if (isset($_SESSION['user'])) {
  
  $loggedUser = $_SESSION['user'];
  if($loggedUser['type'] ==='user'){
    header("Location: index.php");
    exit();
  } 
} else {
    header("Location: login.php"); 
    exit();
  }
$user= new user();
$countUsers = $user->countAll();
$product= new Product();
$countProducts = $product->countAll();
$order= new Order();
$countOrder = $order->countAll();
$orders = $order->getAllProcessing();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>cafe dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
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
                </span> Dashboard
              </h3>
             
            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Orders <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo $countOrder['count']; ?></h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">All Products <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo $countProducts['count']; ?></h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">All users <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo $countUsers['count']; ?></h2>
                  </div>
                </div>
              </div>
            </div>
           
       
            <div class="row">
            <?php foreach ($orders as $orderData) { ?>
        <div class="col-12 bg-white py-3 table-responsive mt-3">
        <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Order Date </th>
                          <th> User name </th>
                          <th>Room no</th>
                          <th>Ext</th>
                          <th> Total price </th>
                          <th> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                        
                                          
                        <tr>
                          <td>
                            <?php echo $orderData['order_date']; ?>
                          </td>
                          <td> <?php echo $orderData['user_name']; ?></td>
                          <td> <?php echo $orderData['room_no']; ?></td>
                          <td> <?php echo $orderData['ext']; ?></td>
                          <td> <?php echo $orderData['total_price']. ' EGP'; ?></td>

                      <td>
                        <button type="button" onClick="deliverOrder(<?php echo $orderData['order_id']; ?>)"class="btn btn-gradient-danger">Deliver</button>
                        
                     


</td> </tr>

                      </tbody>
                    </table>
                    <h3 class="text-center my-4">Order Items</h3>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Product name </th>
                          <th> Item price </th>
                          <th> Quantity </th>
                          <th> SubTotal price </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $id = $orderData['order_id'];
                        $orderItems = $order->showOrderItems($id);
                        foreach ($orderItems as $item) { ?>
                                          
                        <tr>
                          <td>
                            <?php echo $item['name']; ?>
                          </td>
                          <td> <?php echo $item['price']; ?></td>
                        
                          <td> <?php echo $item['quantity']; ?></td>
                          <td> <?php echo ($item['quantity']*$item['price']). ' EGP'; ?></td>
 </tr>
<?php } ?>
                      </tbody>
                    </table>
         </div>
         <?php } ?>
        </div>
          
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- End custom js for this page -->
   <Script> function deliverOrder(orderid) {
  if(confirm('Are you sure?')){
    window.location.href = 'deliverOrder.php?id=' + orderid;
  }
}</script>
  </body>
</html>