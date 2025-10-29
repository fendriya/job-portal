<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
  header("Location: ../index.php");
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
            <h2><i>My Company</i></h2>
            <p>In this section you can change your company details</p>
            <div class="row">
              <form action="update-company.php" method="post" enctype="multipart/form-data">
                <?php
                $sql = "SELECT * FROM company WHERE id_company='$_SESSION[id_company]'";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-6 latest-job ">
                  <div class="form-group">
                     <label>Company Name</label>
                    <input type="text" class="form-control input-lg" name="companyname" value="<?php echo $row['companyname']; ?>" required="">
                  </div>
                  <div class="form-group">
                     <label>Website</label>
                    <input type="text" class="form-control input-lg" name="website" value="<?php echo $row['website']; ?>" required="">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control input-lg" id="email" placeholder="Email" value="<?php echo $row['email']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>About Me</label>
                    <textarea class="form-control input-lg" rows="4" name="aboutme"><?php echo $row['aboutme']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-flat btn-success">Update Company Profile</button>
                  </div>
                </div>
                <div class="col-md-6 latest-job ">
                  <div class="form-group">
                    <label for="contactno">Contact Number</label>
                    <input type="text" class="form-control input-lg" id="contactno" name="contactno" placeholder="Contact Number" onkeypress="return validatePhone(event);" minlength="10" maxlength="10" value="<?php echo $row['contactno']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control input-lg" id="city" name="city"
                    onkeypress="return validateName(event);" value="<?php echo $row['city']; ?>" placeholder="city">
                  </div>
                  <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control input-lg" id="state" onkeypress="return validateName(event);" name="state" placeholder="state" value="<?php echo $row['state']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Change Company Logo</label>
                    <input type="file" name="image" class="btn btn-default">
                    <?php if($row['logo'] != "") { ?>
                    <img src="../uploads/logo/<?php echo $row['logo']; ?>" class="img-responsive" style="max-height: 200px; max-width: 200px;">
                    <?php } ?>
                  </div>
                </div>
                    <?php
                    }
                  }
                ?>
              </form>
            </div>
            <?php if(isset($_SESSION['uploadError'])) { ?>
            <div class="row">
              <div class="col-md-12 text-center">
                <span class="text-danger"><?php echo $_SESSION['uploadError']; ?></span>
              </div>
            </div>
            <?php unset($_SESSION['uploadError']); } ?>
            
          </div>
        </div>
      </div>
    </section>

    

  </div>
  <!-- /.content-wrapper -->
<?php include_once '../inc/footer.php'; ?>
<script type="text/javascript">
   function validatePhone(event) {

        //event.keycode will return unicode for characters and numbers like a, b, c, 5 etc.
        //event.which will return key for mouse events and other events like ctrl alt etc. 
        var key = window.event ? event.keyCode : event.which;

        if(event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
          // 8 means Backspace
          //46 means Delete
          // 37 means left arrow
          // 39 means right arrow
          return true;
        } else if( key < 48 || key > 57 ) {
          // 48-57 is 0-9 numbers on your keyboard.
          return false;
        } else return true;
      }

       function validateName(event) {

        //event.keycode will return unicode for characters and numbers like a, b, c, 5 etc.
        //event.which will return key for mouse events and other events like ctrl alt etc. 
        var key = window.event ? event.keyCode : event.which;

        if(event.keyCode == 8 || event.keyCode == 127 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 32) {
        
          return true;
        } else if( key < 65 || key > 90 && key < 97 || key > 122) {
          // 65-90 97-122 is A-Z a-z alphabets on your keyboard.
          return false;
        } else return true;
      }

</script>
</body>
</html>
