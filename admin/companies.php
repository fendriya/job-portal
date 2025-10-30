<?php

session_start();

if(empty($_SESSION['id_admin'])) {
  header("Location: index.php");
  exit();
}

require_once("../db.php");
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

            <h3>Companies</h3>
            <div class="row margin-top-20">
              <div class="col-md-12">
                <div class="box-body table-responsive no-padding">
                  <table id="example2" class="table table-hover">
                    <thead>
                      <th>Company Name</th>
                      <th>Account Creator Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>City</th>
                      <th>State</th>
                      <th>Country</th>
                      <th>Status</th>
                      <th>Delete</th>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM company ORDER BY id_company DESC";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                      ?>
                      <tr>
                        <td><?php echo $row['companyname']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['contactno']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['state']; ?></td>
                        <td><?php echo $row['country']; ?></td>
                        <td>
                        <?php
                          if($row['active'] == '1') {
                           echo '<span class="label label-success">Activated</span>';
                          } elseif($row['active'] == '2') {
                            ?>
                            <a href="reject-company.php?id=<?php echo $row['id_company']; ?>"><span class="label label-danger">Reject</span></a> <a href="approve-company.php?id=<?php echo $row['id_company']; ?>"><span class="label label-success">Approve</span></a>
                            <?php
                          } elseif ($row['active'] == '3') {
                            ?>
                              <a href="approve-company.php?id=<?php echo $row['id_company']; ?>"><span class="label label-warning">Reactivate</span></a>
                            <?php
                          } elseif($row['active'] == '0') {
                            echo '<span class="label label-danger">Rejected</span>';
                          }
                        ?>
                        <td class="text-center"><a href="delete-company.php?id=<?php echo $row['id_company']; ?>"><i class="fa fa-trash"></i></a></td>
                      </tr>
                     <?php
                        }
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
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
  $(function () {
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>
</body>
</html>
