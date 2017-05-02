<?php
session_start();
require_once '../includes/class.session.php';

$reg_user = new SESSION();

if(isset($_POST['register'])) {
  $uname = $_POST['fullname'];
  $email = $_POST['email'];
  $upass = $_POST['password'];
  $confirmPass = $_POST['verifyPassword'];
  $phone = $_POST['phoneNumber'];
  $code = md5(uniqid(rand()));


  $stmt = $reg_user->runQuery("SELECT * FROM users WHERE Email=:email_id");
  $stmt->execute(array(":email_id" => $email));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($stmt->rowCount() > 0) {
    $msg = "
          <div class='alert alert-error'>
          <strong>We're sorry. </strong>This email already exists. Please choose another email. 
        </div>
        ";
  } else {
    if ($upass == $confirmPass) {
      if ($reg_user->register($uname, $email, $upass, $phone, $code)) {
        $id = $reg_user->lasdID();
        $key = base64_encode($id);
        $id = $key;

        $message = "          
              Hello $uname,
              <br /><br />
              Welcome to our site.!<br/>
              To complete your registration  please , just click following link<br/>
              <br /><br />
              <a href='labcourse.online-presence.com/verify.php?id=$id&code=$code'>Please click HERE to Activate your account.</a>
              <br /><br />
              Thanks,";

        $subject = "Confirm Registration";

        $reg_user->send_mail($email, $message, $subject);

        $msg = "
            <div class='alert alert-success'>
              <strong>Success!</strong>  We've sent an email to $email.
            Please click on the confirmation link in the email to create your account. 
            </div>
            ";

      } else {
        echo "sorry , Query could no execute...";
      }
    } else {
      $msg = "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>We're sorry.!</strong>  The passwords don't match.
          </div>";

    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>iMenu | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index.php"><b>iMenu</b> Registration</a>
  </div>

  <div class="register-box-body">
    <?php if (isset($msg)) echo $msg; ?>
    <p class="login-box-msg">Register a new membership</p>

    <form id="form-signup" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Full Name" name="fullname">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" required="required">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required="required">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Retype password" name="verifyPassword" required="required">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Phone number" name="phoneNumber">
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
      </div>

      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="register" >Register</button>
          
          
        </div>
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="cancel" >Cancel</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <br/>
    <a href="login.php" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
