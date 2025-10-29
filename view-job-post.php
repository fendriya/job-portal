<?php
//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");
?>
<?php include_once 'inc/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <?php include_once 'inc/navbar.php'; ?>
  <div class="content-wrapper" style="margin-left: 0px;">
  <?php
    $sql = "SELECT * FROM job_post INNER JOIN company ON job_post.id_company=company.id_company
    WHERE id_jobpost='$_GET[id]'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
  ?>
    <section id="candidates" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 bg-white padding-2">
            <div class="attachment-block clearfix">
              <img class="attachment-img" src="uploads/logo/<?php echo $row['logo']; ?>" alt="Attachment">
              <div class="attachment-pushed">
                <h3><?php echo $row['companyname']; ?></h3>
              </div>
            </div>
            
            <div class="pull-left">
              <h2><b><i><?php echo $row['jobtitle']; ?></i></b></h2>
            </div>
            <div class="pull-right">
              <a href="jobs.php" class="btn btn-default btn-lg btn-flat margin-top-20">
                <i class="fa fa-arrow-circle-left"></i> Back
              </a>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div>
              <p>
                <span class="margin-right-10">
                  <i class="fa fa-location-arrow text-green"></i> <?php echo $row['city']; ?>
                </span>
                <i class="fa fa-calendar text-green"></i> <?php echo date("d-M-Y", strtotime($row['createdat'])); ?>
              </p>
            </div>
            <div>
              <?php echo stripcslashes($row['description']); ?>
            </div>
            <?php
            if(isset($_SESSION["id_user"]) && empty($_SESSION['companyLogged'])) { ?>
            <div>
              <a href="apply.php?id=<?php echo $row['id_jobpost']; ?>" class="btn btn-success btn-flat margin-top-50">
                Apply
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
    <?php
      }
    }
    ?>
  </div>
  <!-- /.content-wrapper -->
<?php include_once 'inc/footer.php'; ?>
</body>
</html>
