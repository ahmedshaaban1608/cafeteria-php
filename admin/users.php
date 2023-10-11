<?php
  session_start();
  require_once "../vendor/autoload.php";
  use App\Classes\User;
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

  $user = new User();
  $users = $user->getAll();
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
                  </span> Users
                </h3>
              
              </div>
              
  <div class="row">
          <div class="col-12 bg-white p-3 table-responsive">
          <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>image </th>
                            <th> Name </th>
                            <th> Room </th>
                            <th> ext </th>
                            <th style="width:300px!important;"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
               <?php foreach ($users as $user) { ?>
                <tr>
                            <td class="py-1">
                              <img src="<?php echo $user['profile_img']; ?>" alt="image" />
                            </td>
                            <td> <?php echo $user['fullname']; ?> </td>
                          
                            <td> <?php echo $user['room_no']; ?></td>
                            <td> <?php echo $user['ext']; ?></td>
                        <td class="d-flex">                   
                        <button onClick="editUser(<?php echo $user['id']; ?>)"  type="button" class="btn btn-primary px-2 me-2">Edit</button>
                        <button  onClick="deleteUser(<?php echo $user['id']; ?>)" type="button" class="btn btn-danger px-2 me-2">Delete</button>


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
function editUser(productId) {
  window.location.href = 'editUser.php?id=' + productId;
}
function deleteUser(productId) {
  if(confirm('Are you sure?')){
    window.location.href = 'deleteUser.php?id=' + productId;
  }
}

      </script>
    </body>
  </html>