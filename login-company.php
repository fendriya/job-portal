<?php
  session_start();

if(isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) {
  header("Location: index.php");
  exit();
}

include_once 'inc/header.php';
?>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Job</b> Portal</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg" style="font-size:18px; margin-bottom:18px;">Welcome back — Company Login</p>

    <form method="post" action="checkcompanylogin.php" novalidate>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" required autofocus aria-label="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required aria-label="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row login-actions">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>
    <a class="signup-link" href="sign-up.php">Don't have an account? Sign up</a>
    <br>

    <?php
      //If Company have successfully registered then show them this success message
      if(isset($_SESSION['registerCompleted'])) { ?>
        <div class="info-text"><p class="text-success">You have registered successfully! Your account approval is pending by admin.</p></div>
    <?php unset($_SESSION['registerCompleted']); }

      //If Company Failed To log in then show error message.
      if(isset($_SESSION['loginError'])) { ?>
        <div class="info-text"><p class="text-danger">Invalid Email/Password! Try Again!</p></div>
    <?php unset($_SESSION['loginError']); }

      if(isset($_SESSION['companyLoginError'])) { ?>
        <div class="info-text"><p class="text-danger"><?php echo $_SESSION['companyLoginError']; ?></p></div>
    <?php unset($_SESSION['companyLoginError']); }
    ?>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<!-- iCheck -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
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
