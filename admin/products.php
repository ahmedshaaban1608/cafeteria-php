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
        
            </div>
            <div class="row">
          <div class="col-12 bg-white p-3 table-responsive">
          <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Order Date </th>
                            <th> Status </th>
                            <th> Amount </th>
                            <th style="width:200px!important;"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="py-1">
                              <img src="../assets/images/faces-clipart/pic-1.png" alt="image" />
                            </td>
                            <td> Herman Beck </td>
                          
                            <td> $ 77.99 </td>
                        <td>                       <button type="button" class="btn btn-gradient-primary me-2">Show</button>                       <button type="button" class="btn btn-gradient-warning  text-dark">Delete</button>


  </td> </tr>

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
    </body>
  </html>