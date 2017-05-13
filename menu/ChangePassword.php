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
?> 
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <div class="container">
    <!-- Main content -->
  <div class="container">
     <h2>Change Password</h2>
    <div class="row">

      <?php

  $userId = $userInfo['userId'];

  $user = new SESSION();

  if (isset($_POST['action']) && $_POST['action'] == 'update') {
  
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newpass'];
    $confirmNewPassword = $_POST['newpassconfirm'];

    //var_dump($user);


    //echo $newPassword;
    //echo $confirmNewPassword;
    if (password_verify($oldPassword, $userInfo['userPassword'])) {
      if ($newPassword === $confirmNewPassword && !empty($newPassword) && !empty($confirmNewPassword)) {

        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $user->changePassword($userId,$newPassword);
        $msg = "Your Password has been succesfully changed.";
      } else {
        $msg = "Your new password is incorrect, please try again.";
      }
    } else {
      if (empty($oldPassword) && empty($newPassword) && empty($confirmNewPassword)) {

        $msg = "You didn't fill out any of the fields.";
      } elseif (empty($oldPassword)) {
        $msg = "You didn't type your current password.";
      } else {
        $msg = "Your current password has been typed incorrectly. Try again.";
      }

    }


    //echo '<p>Your account details have been successfully updated!</p>';
    ?>
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-push-2 col-sm-10 col-sm-push-1">
          <div class="alert alert-success">
            <?php echo $msg; ?>
          </div>
        </div>
      </div>
    </div>
    <?php
  }


  // $user = $session->getUser($userId);
  ?>
      
      <div class="col-md-6 col-md-push-3 col-sm-8 col-sm-push-2"  style="left: 0%; margin-top:30px;"> 
          <form class="admin-form" method="post">
            <div class="form-group">
              <label for="name">Current Password:</label>
              <input type="Password" id="Pass" class="form-control" name="oldPassword" />
            </div>
              <div class="form-group">
              <label for="name">New Password:</label>
              <input type="Password" id="Pass" class="form-control" name="newpass" />
            </div>
            <div class="form-group">
              <label for="name">Retype New Password:</label>
              <input type="Password" id="Pass" class="form-control" name="newpassconfirm" />
            </div>
          <button type="submit" class="mu-btn icon go" title="Update" name="action" value="update">Update</button>
        </form>
      </div>
    </div>
  </div>




    </div>
 <!--  <footer class="main-footer" style="margin-top: 50px;">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer> -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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