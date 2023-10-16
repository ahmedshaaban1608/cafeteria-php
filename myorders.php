<?php 
session_start();
if (isset($_SESSION['user'])) {
  
  $loggedUser = $_SESSION['user'];
  if($loggedUser['type'] ==='admin'){
    header("Location: admin/index.php");
    exit();
  } 
} else {
    header("Location: login.php"); 
    exit();
  }
require_once 'vendor/autoload.php';
use App\Classes\Order;
$order = new Order();
$orders = $order->getAllByUser($loggedUser['id']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>my orders</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
           <!-- partial:partials/_navbar.html -->
     <?php require_once('includes/header.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
       <?php require_once('includes/sidebar.php') ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> My orders
              </h3>
           
            </div>
         <div class="row">
        <div class="col-12 bg-white py-3 table-responsive">
        <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Order Date </th>
                          <th> Status </th>
                          <th> Total price </th>
                          <th style="width:200px!important;"> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($orders as $key => $order) { ?>
                                          
                        <tr>
                          <td>
                            <?php echo $order['order_date']; ?>
                          </td>
                          <td> <?php echo $order['status']; ?></td>
                        
                          <td> <?php echo $order['total_price']; ?></td>

                      <td> <a type="button" href="showOrder.php?id=<?php echo $order['order_id']; ?>" class="btn btn-gradient-primary me-2">Show</a>
                      <?php if($order['status'] == 'processing'){ ?>
                        <button type="button" onClick="cancelOrder(<?php echo $order['order_id']; ?>)"class="btn btn-gradient-warning  text-dark">Cancel</button>
                        
                     <?php } ?>


</td> </tr>
<?php } ?>
                      </tbody>
                    </table>
         </div>
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
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- End custom js for this page -->
    <script>
      
function cancelOrder(orderid) {
  if(confirm('Are you sure?')){
    window.location.href = 'cancelOrder.php?id=' + orderid;
  }
}
</script>
  </body>
</html>