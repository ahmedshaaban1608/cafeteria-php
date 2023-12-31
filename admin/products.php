<?php
  session_start();
  require_once "../vendor/autoload.php";
  use App\Classes\Product;
  if (isset($_SESSION["user"])) {
      $loggedUser = $_SESSION["user"];
      if ($loggedUser["type"] === "user") {
          header("Location: index.php");
          exit();
      }
  } else {
      header("Location: login.php");
      exit();
  }
  $error_arr = [];
  if (isset($_SESSION["product_errors"])) {
      $error_arr = $_SESSION["product_errors"];
      unset($_SESSION["product_errors"]);
  }
  $product = new Product();
  $products = $product->getAll();
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
      <?php require_once "includes/adminheader.php"; ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
          <!-- partial:partials/_sidebar.html -->
        <?php require_once "includes/adminsidebar.php"; ?>
          <!-- partial -->
          <div class="main-panel">
            <div class="content-wrapper">
              <div class="page-header">
                <h3 class="page-title">
                  <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                  </span> Products
                </h3>
              
              </div>
              <div class="row">
                <div class="col-12 bg-white mb-4 py-4">
                  <h2 class="text-center">Add Product</h2>
                  <form class="pt-3" action="addProduct.php" method="post" enctype="multipart/form-data">
                       <div class="form-group">
                          <label for="name">product name <span>*</span></label>
                          <input type="text" class="form-control mb-2" id="name" placeholder=" product name" name="name" required>
                          <span class="text-danger"><?php if (
                              isset($error_arr["name"])
                          ) {
                              echo $error_arr["name"];
                          } ?></span>
                        </div>
                      <div class="form-group">
                          <label for="price">price <span>*</span></label>
                          <input type="number" class="form-control mb-2" id="price" placeholder="enter price" name="price" required>
                          <span class="text-danger mt-2"><?php if (
                              isset($error_arr["price"])
                          ) {
                              echo $error_arr["price"];
                          } ?></span>
                        </div>
                        <div class="form-group">
                          <label>product image  <span>*</span></label>
                          <input type="file" name="img" class="file-upload-default">
                          <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info mb-2" name="profile" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                              <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                            </span>
                          </div>
                          <span class="text-danger mt-2"><?php if (
                              isset($error_arr["img"])
                          ) {
                              echo $error_arr["img"];
                          } ?></span>
                        </div>
                                            
                    <input type="submit" name="product-btn" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn w-100" value="Add product">
                
                    </div>
                
                    
                  </form>
  </div>
  <div class="row">
          <div class="col-12 bg-white p-3 table-responsive">
          <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>image </th>
                            <th> Product </th>
                            <th> Price </th>
                            <th style="width:300px!important;"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
               <?php foreach ($products as $product) { ?>
                <tr>
                            <td class="py-1">
                              <img src="<?php echo $product['img']; ?>" alt="image" />
                            </td>
                            <td> <?php echo $product['name']; ?> </td>
                          
                            <td> <?php echo $product['price']; ?> EGP</td>
                        <td class="d-flex">                    <button onclick="changeAvailabilty(<?php echo $product['id']; ?>, false)" type="button" class="btn btn-success me-2 px-2 <?php echo $product['is_available'] ? 'd-block' : 'd-none'; ?>">Available</button>
  
                        <button onclick="changeAvailabilty(<?php echo $product['id']; ?>, true)" type="button" class="btn btn-danger me-2 px-2 <?php echo !$product['is_available']? 'd-block' : 'd-none'; ?>">Not Available</button>     
                        
                        <button onClick="editProduct(<?php echo $product['id']; ?>)"  type="button" class="btn btn-primary px-2 me-2">Edit</button>
                        <button  onClick="deleteProduct(<?php echo $product['id']; ?>)" type="button" class="btn btn-danger px-2 me-2">Delete</button>


  </td> </tr>
                <?php } ?>

                        </tbody>
                      </table>
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
      <script src="../assets/js/file-upload.js"></script>
      <!-- End custom js for this page -->
      <script>
       function changeAvailabilty(productId, status) {
  window.location.href = 'available.php?id=' + productId + '&status='+status;
}
function editProduct(productId) {
  window.location.href = 'editProduct.php?id=' + productId;
}
function deleteProduct(productId) {
  if(confirm('Are you sure?')){
    window.location.href = 'deleteProduct.php?id=' + productId;
  }
}

      </script>
    </body>
  </html>