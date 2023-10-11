<?php
 session_start();
 require_once 'vendor/autoload.php';

use App\Classes\Product;
use App\Classes\Room;
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
  $cart =[];
  $in_cart = false;
  if (isset($_SESSION['cart'])) {

$cart = $_SESSION['cart'];
if(count($cart))$in_cart = true;
  }
$cartIds = array_column($cart, 'id');

$product = new Product();
$products = $product->getAllAvailable();
$room = new Room();
$rooms = $room->getAll();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>cafe dashboard</title>
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
                </span> Make an Order
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
        <div class="row">
          
          <div class="col-12 cart mb-5">
            <div class="shadow bg-white p-3 rounded-3">
        <?php if(!$in_cart){ ?>
          <h3 class="text-center">cart is empty <br>order a drink</h3>
        <?php } else{?>
          <h2 class="text-center mb-3"">Cart</h2>
          <form action="completeOrder.php" method="post">
          <table class="w-100">
    <thead style="line-height: 1.7em">
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cart as $p) { ?>
            <tr style="line-height: 1.7em;">
                <td><?php echo $p['name']; ?></td>
                <td>
                    <input class="mb-2" type="number" min="1" max="30" value = "<?php echo $p['quantity']; ?>" name="quantity" oninput="calculateTotal(this,<?php echo $p['id']; ?>, <?php echo $p['price']; ?>)">
                </td>
                <td class="subtotal"><?php echo ($p['price']*$p['quantity']);?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<input type="text" name="userid" readonly hidden value="<?php echo $loggedUser['id']; ?>">

<div class="form-group">
<textarea name="note" id="note" placeholder="order notes" rows="10" class="form-control"></textarea>
</div>
<div class="form-group">
                        <label for="room">Room no <span>*</span></label>
                        <select class="form-control mb-2" id="room" name="room" required>
                          <?php foreach ($rooms as $room) {
                          echo "<option value='$room[room_no]'>$room[room_no]</option>";
                          
                          } ?>
                        </select>
                        </div>
<hr>

<div class="text-center"> <h4>Total Price</h4> <p class="totalPrice"></p>
<input type="submit" value="Complete order" name="order_btn" class="btn btn-primary">
</div>
</form>
<script>
 var totalPrice = 0
 <?php if(!$in_cart) { ?>
  totalPrice = 0
  <?php } ?>
  var prices= document.querySelectorAll('.subtotal')
        prices.forEach(price => {
          totalPrice += +price.textContent
        });
        document.querySelector('.totalPrice').textContent = totalPrice + ' EGP'
    function calculateTotal(input,productId, price) {
      totalPrice = 0
        var quantity = input.value;
   

        prices= document.querySelectorAll('.subtotal')
        prices.forEach(price => {
          totalPrice += +price.textContent
        });
document.querySelector('.totalPrice').textContent = totalPrice + ' EGP';
updateQuantityInCart(productId, quantity)
    }
    function updateQuantityInCart(productId, quantity) {
    window.location.href = `updateQuantity.php?id=${productId}&quantity=${quantity}`;
}
</script>
       <?php  } ?>
            </div>
          </div>
          <div class="col-12">

<div class="row g-4">
  <?php foreach ($products as $product) { ?>
    <div class="col-md-6 col-lg-3">
  <div class="card shadow">
  <img src="<?php echo $product['img']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 130px;">
  <div class="card-body p-2 text-center">
    <h5 class="card-title"><?php echo $product['name']; ?></h5>
    <p class="card-text">Price: <?php echo $product['price']; ?> EGP</p>
  <?php if(in_array($product['id'],$cartIds)){ ?>
    <a href="<?php echo 'removeInCart.php?id='.$product['id']?>" class="btn btn-success">added to cart</a>
  <?php } else { ?>
      <a href="<?php echo 'makeOrder.php?id='.$product['id'].'&name='.$product['name'].'&price='.$product['price'] ; ?>" class="btn btn-primary">add to cart</a>
 <?php } ?>
  </div>
</div>
  </div>
  <?php } ?>
  
</div>
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
  </body>
</html>