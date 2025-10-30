<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter view-job-post.php in URL.
if(empty($_SESSION['id_company'])) {
  header("Location: ../index.php");
  exit();
}

?>
<?php include_once 'inc/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
<?php include_once 'inc/navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">

    <section id="candidates" class="content-header">
      <div class="container">
        <div class="row">
          <?php include_once 'inc/sideMenu.php'; ?>
          <div class="col-md-9 bg-white padding-2">
            <h2><i>Account Settings</i></h2>
            <p>In this section you can change your name and account password</p>
            <div class="row">
              <div class="col-md-6">
                <form id="changePassword" action="change-password.php" method="post">
                  <div class="form-group">
                    <input id="password" class="form-control input-lg" type="password" name="password" autocomplete="off" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <input id="cpassword" class="form-control input-lg" type="password" autocomplete="off" placeholder="Confirm Password" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-flat btn-success btn-lg">Change Password</button>
                  </div>
                  <div id="passwordError" class="color-red text-center hide-me">
                    Password Mismatch!!
                  </div>
                </form>
              </div>
              <div class="col-md-6">
                <form action="update-name.php" method="post">
                  <div class="form-group">
                    <label>Your Name (Full Name)</label>
                    <input class="form-control input-lg" name="name" type="text">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-flat btn-primary btn-lg">Change Name</button>
                  </div>
                </form>
              </div>
            </div>
            <br>
            <br>
            <div class="row">
              <div class="col-md-6">
                <form action="deactivate-account.php" method="post">
                  <label><input type="checkbox" required> I Want To Deactivate My Account</label>
                  <button class="btn btn-danger btn-flat btn-lg">Deactivate My Account</button>
                </form>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>

    

  </div>
  <!-- /.content-wrapper -->

<?php include_once '../inc/footer.php'; ?>
<script>
  $("#changePassword").on("submit", function(e) {
    e.preventDefault();
    if( $('#password').val() != $('#cpassword').val() ) {
      $('#passwordError').show();
    } else {
      $(this).unbind('submit').submit();
    }
  });
</script>
</body>
</html>
