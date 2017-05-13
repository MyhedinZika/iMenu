<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Blank Page</title>
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

   <!-- SweetAlert  style -->
  <link rel="stylesheet" href="../plugins/sweetalert/sweetalert.css">

  <!-- responsive datatables -->
  <link rel="stylesheet" href="../plugins/datatables/extensions/Responsive/css/dataTables.responsive.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue layout-top-nav">
<!-- Site wrapper -->
<div class="wrapper">
<?php 
  include 'header.php';
  $userChange = 0;
?> 
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
 
    <!-- Main content -->

  <div class="container">
  
    <h2>Edit User Details</h2>
    <div class="row">
      <div class="userDetails">
      <div class="col-md-6 col-md-push-3 col-sm-8 col-sm-push-2"  style="left: 0%;" >
      <?php
        if (isset($_POST['action']) && $_POST['action'] == 'update') {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $userId = $userInfo['userId'];
    $user->editUserInfo($userId,$name,$phone);
    $userChange  = 2;


  }
    $userInfo = $user->getUser($userId);
       ?>
        <?php
            if($userChange == 2){
              echo '<div class="form-group">
          <div class="alert alert-success" >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            Your account details have been successfully updated!
          </div>
        </div>';
            }
           ?>
        <form class="admin-form" method="post">
        
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" id="name" class="form-control" name="name" value="<?= $userInfo['Full_Name'] ?>" />
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" id="email" class="form-control" name="email" value="<?= $userInfo['Email'] ?>" disabled/>
            </div>
            <div class="form-group">
              <label for="phone">Phone:</label>
              <input type="text" id="phone" class="form-control" name="phone" value="<?= $userInfo['Phone'] ?>"/>
            </div>
          
          <div class="buttons">
            <button type="submit" class="mu-btn icon go" title="Update" name="action" value="update">Update</button>
            <a class="mu-btn icon cancel"  title="Cancel" href="account_details.php">Cancel</a>
          </div>
         
          </form>
          
      </div>
      </div>
      <?php
         
       if (isset($_POST['action']) && $_POST['action'] == 'Save Changes') {
    try {

      $user = new SESSION();

    if(isset($_FILES['image'])){

      print_r($_FILES);
      $imgFile = $_FILES['new-image']['name'];
      $tmp_dir = $_FILES['new-image']['tmp_name'];
      $imgSize = $_FILES['new-image']['size'];
      $userId = $userInfo['userId'];

     

    }
      // $prices = $_POST['price'];

   if (empty($imgFile)) {
      $errMSG = "Please Select Image File.";
    } else {
      $upload_dir = __DIR__ . '/user_images/'; // upload directory 

      $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

      // valid image extensions
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

      // rename uploading image
      $userpic = rand(1000, 1000000) . "." . $imgExt;

      // allow valid image file formats
      if (in_array($imgExt, $valid_extensions)) {
        // Check file size '5MB'
        if ($imgSize < 5000000) {
          move_uploaded_file($tmp_dir, $upload_dir . $userpic);
        } else {
          $errMSG = "Sorry, your file is too large.";
        }
      } else {
        $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      }
    }
       

      if (!isset($errMSG)) {
        $user->updateProfilePicture($userId,$userPic);
      }


    } catch (Exception $e) {
      return $e->getMessage();
    }


  }
  ?> 

      <div class="col-md-6 col-md-push-3 col-sm-8 col-sm-push-2"  style="left: 6%; margin-top: -74px;">
      
          <form class="admin-form" method="post" enctype="multipart/form-data">
           <div class="form-group">
              <legend style="margin-top: 40px;">Change Your Photo</legend>
                  
            
              <img class="product-photo" src="user_images/<?= $userInfo['userPicture'] ?>" style="
    width: 200px;"/>
    <br/><br/>
           
              <label for="name">Update Photo:</label><br/>
              <input type="file" class="mu-btn icon go" style="display: inline;
              " id="new-image" name="new-image"> 
              <input type="submit" class="mu-btn icon go" name="action" value="Save Changes">
            </div>
        </form>
      </div>
    </div>
  </div>




   

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <!-- <div class="control-sidebar-bg"></div> -->
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
    <!-- <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
<!-- jQuery 2.2.3 -->
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
 <!-- SweetAlert -->
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
    <!-- Bootstrap-notify -->
<script src="../plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="../plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="users.js"></script> 

</body>
</html>
