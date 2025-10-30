<?php

session_start();

if(isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) {
  header("Location: index.php");
  exit();
}

?>
<?php include_once 'inc/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <?php include_once 'inc/navbar.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">
    <section class="content-header">
      <div class="container">
        <div class="row latest-job margin-top-50 margin-bottom-20">
          <h1 class="text-center margin-bottom-20">Sign Up</h1>
          <div class="col-md-6 col-sm-6 col-xs-12 latest-job ">
            <div class="small-box bg-yellow padding-5">
              <div class="inner">
                <h3 class="text-center">User Registration</h3>
              </div>
              <a href="register-candidates.php" class="small-box-footer">
                Register <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12 latest-job ">
            <div class="small-box bg-red padding-5">
              <div class="inner">
                <h3 class="text-center">Company Registration</h3>
              </div>
              <a href="register-company.php" class="small-box-footer">
                Register <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    

  </div>
  <!-- /.content-wrapper -->

<?php include_once 'inc/footer.php'; ?>
</body>
</html>
