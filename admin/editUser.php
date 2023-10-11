<?php
  session_start();
  require_once "../vendor/autoload.php";
  use App\Classes\User;
  use App\Classes\Room;
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
  if (isset($_SESSION["user_errors"])) {
      $error_arr = $_SESSION["user_errors"];
      unset($_SESSION["user_errors"]);
  }
  $user = new user();
  $id = $_GET['id'];
  $usr = $user->show($id);
  $room = new Room();
$rooms = $room->getAll();

  if(isset($_POST['user-btn']) && $_SERVER["REQUEST_METHOD"] === "POST" ){

    $name = $_POST['name'];
    $room = $_POST['room'];
    $ext = $_POST['ext'];
    $img = $usr['profile_img'];
    
    $error_arr = [];
    if($_FILES['img']['name']){
      $f_name = $_FILES['img']['name'];
      $f_size = $_FILES['img']['size'];
      $f_path = $_FILES['img']['tmp_name'];
      $type_arr = explode(' ','jpg png jpeg webp gif');
          $is_img = $user->fileValidator($f_name, $type_arr, $f_size, '2097152');
          if(!$is_img) $error_arr['img']='must be a vaild image with size less than 2 MB';
    }
      $is_name = $user->validateFullName($name);
      $is_room = $user->validateNumber($room);
      $is_ext = $user->validateNumber($ext);
  
      if(!$is_name) $error_arr['name']='invalid name';
       if (!$is_room) $error_arr['room']='invalid room number';
       if (!$is_ext) $error_arr['ext']='invalid ext number';

        
      // redirect me if there is an error
      if(count($error_arr)){
      
        $_SESSION['user_errors'] = $error_arr;
        header("Location: editUser.php?id=".$id);
        exit();
      }
      if($_FILES['img']['name']){
      move_uploaded_file($f_path, '../assets/uploads/'.(time() - 1696070596).$f_name);
      $img = '/cafe/assets/uploads/'.(time() - 1696070596).$f_name;
      }

    $user->_set('fullname',$name);
    $user->_set('room_no',$room);
    $user->_set('ext',$ext);
    $user->_set('profile_img',$img);
    
    $result = $user->update($id);
    header("Location: users.php");
    }

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
                  </span> Edit user
                </h3>
              
              </div>
              <div class="row">
                <div class="col-12 bg-white mb-4 py-4">
                <form class="pt-3" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="name">Name <span>*</span></label>
                        <input type="text" class="form-control mb-2" id="name" placeholder=" Full Name" name="name" value="<?php echo $usr['fullname']; ?>" required>
                        <span class="text-danger"><?php if(isset($error_arr['name'])) echo $error_arr['name']; ?></span>
                      </div>
                    
                      <div class="form-group">
                        <label for="room">Room no <span>*</span></label>
                        <select class="form-control mb-2" id="room" name="room">
                          <option selected disabled>seelct room no</option>
                          <?php foreach ($rooms as $room) { ?>
                          <option value="<?php echo $room['room_no']; ?>" <?php echo $room['room_no'] === $usr['room_no']? 'selected': ''; ?>> <?php echo $room['room_no']; ?></option>";
                          
                          <?php } ?>
                        </select>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['room'])) echo $error_arr['room']; ?></span>
                      </div>
                      <div class="form-group">
                        <label for="ext">Ext <span>*</span></label>
                        <input type="number" class="form-control mb-2" id="ext" placeholder="enter Ext" name="ext" value="<?php echo $usr['ext']; ?>" required>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['ext'])) echo $error_arr['ext']; ?></span>
                      </div>
                      <div class="form-group">
                        <label>profile  <span>*</span></label>
                        <input type="file" name="img" class="file-upload-default" value="<?php echo $usr['profile_img']; ?>" >
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info mb-2" name="profile" disabled placeholder="Upload Image" value="<?php echo $usr['profile_img']; ?>">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                          </span>
                        </div>
                        <span class="text-danger mt-2"><?php if(isset($error_arr['img'])) echo $error_arr['img']; ?></span>
                      </div>
                                          
                  <input type="submit" name="user-btn" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn w-100" value="Edit user">
               
                  </div>
                  
                </form>
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