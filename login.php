<?php
session_start();
require_once 'vendor/autoload.php';
use App\Classes\User;
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
  

$error = false;
if(isset($_POST['login-btn']) && $_SERVER["REQUEST_METHOD"] === "POST" ){
$email = $_POST['email'];
$password = $_POST['password'];
$user = new user();
$is_email = $user->validateEmail($email);
if($is_email){
  $account = $user->showByEmail($email);
  if(count($account) && $account['hashed_password'] === md5($password)){
    $_SESSION['user'] = $account;
    var_dump($_SESSION['user']);  
header('Location: index.php');
exit();
  } else{
    $error = true;
  }
}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cafe login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="./assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth ">
          <div class="row flex-grow ">
            <div class="col-lg-6 mx-auto ">
          
              <div class="auth-form-light text-left p-5 shadow">
           
                <div class="brand-logo">
                  <a href="index.php"><img src="./assets/images/logo.png"></a>
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form class="pt-3" method="post">
                <div class="alert alert-warning <?php echo ($error) ? "d-block" : "d-none"; ?>" role="alert">
  Incorrect email or password!!
</div>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" name="email" placeholder="email">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                  </div>
                  <div class="mt-3">
                    <input type="submit" name="login-btn" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn w-100" value="SIGN IN">
                  </div>
                 
                    <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.php" class="text-primary">Create</a>
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
    <script src="./assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="./assets/js/off-canvas.js"></script>
    <script src="./assets/js/hoverable-collapse.js"></script>
    <script src="./assets/js/misc.js"></script>
    <!-- endinject -->
  </body>
</html>