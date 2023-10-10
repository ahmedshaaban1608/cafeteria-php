<?php
session_start();
if (isset($_SESSION['user'])) {
$loggedUser = $_SESSION['user'];

if($loggedUser['type'] ==='admin'){
  header("Location: admin/index.php");
  exit();
} else {

  header("Location: index.php");
  exit();
}
}
$error_arr = [];
if(isset($_SESSION['register_errors'])){
  $error_arr =  $_SESSION['register_errors'];
unset($_SESSION["register_errors"]);
}
require_once 'vendor/autoload.php';
use App\Classes\Room;
$room = new Room();
$rooms = $room->getAll();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>cafe register</title>
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
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-6 mx-auto">
         
              <div class="auth-form-light text-left p-5 shadow">
             
                <div class="brand-logo">
                <a href="index.php"><img src="assets/images/logo.png"></a>                </div>
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form class="pt-3" action="create.php" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="name">Name <span>*</span></label>
                        <input type="text" class="form-control mb-2" id="name" placeholder=" Full Name" name="name" required>
                        <span class="text-danger"><?php if(isset($error_arr['name'])) echo $error_arr['name']; ?></span>
                      </div>
                      <div class="form-group">
                        <label for="email">Email address <span>*</span></label>
                        <input type="email" class="form-control mb-2" id="email" placeholder="Email" name="email" required>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['email'])) echo $error_arr['email']; ?></span>
                      </div>
                      <div class="form-group">
                        <label for="password">Password <span>*</span></label>
                        <input type="password" class="form-control mb-2" id="password" placeholder="Password" name="password" required>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['password'])) echo $error_arr['password']; ?></span>
                      </div>
                      <div class="form-group">
                        <label for="confirm_password">Confirm Password <span>*</span></label>
                        <input type="password" class="form-control mb-2" id="confirm_password" placeholder="confirm Password" name="confirm_password" required>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['confirm_password'])) echo $error_arr['confirm_password']; ?></span>
                      </div>
                      <div class="form-group">
                        <label for="room">Room no <span>*</span></label>
                        <select class="form-control mb-2" id="room" name="room">
                          <option selected disabled>seelct room no</option>
                          <?php foreach ($rooms as $room) {
                          echo "<option value='$room[room_no]'>$room[room_no]</option>";
                          
                          } ?>
                        </select>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['room'])) echo $error_arr['room']; ?></span>
                      </div>
                      <div class="form-group">
                        <label for="ext">Ext <span>*</span></label>
                        <input type="number" class="form-control mb-2" id="ext" placeholder="enter Ext" name="ext" required>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['ext'])) echo $error_arr['ext']; ?></span>
                      </div>
                      <div class="form-group">
                        <label>profile  <span>*</span></label>
                        <input type="file" name="img" class="file-upload-default">
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info mb-2" name="profile" disabled placeholder="Upload Image">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                          </span>
                        </div>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['img'])) echo $error_arr['img']; ?></span>
                      </div>
                                          
                  <input type="submit" name="register-btn" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn w-100" value="CREATE ACCOUNT">
                  <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="login.php" class="text-primary">Login</a>
                  </div>
                  </div>
                  
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/file-upload.js"></script>

    <!-- endinject -->
  </body>
</html>