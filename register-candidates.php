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
        <div class="row latest-job margin-top-50 margin-bottom-20 bg-white">
          <h1 class="text-center margin-bottom-20">CREATE YOUR PROFILE</h1>
          <form method="post" id="registerCandidates" action="adduser.php" enctype="multipart/form-data">
            <div class="col-md-6 latest-job ">
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="fname" name="fname" placeholder="First Name *" required>
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="lname" name="lname" placeholder="Last Name *" required>
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="email" name="email" placeholder="Email *" required>
              </div>
              <div class="form-group">
                <textarea class="form-control input-lg" rows="4" id="aboutme" name="aboutme" placeholder="Brief intro about yourself *" required></textarea>
              </div>
              <div class="form-group">
                <label>Date Of Birth</label>
                <input class="form-control input-lg" type="date" id="dob" min="1960-01-01" max="1999-01-31" name="dob" placeholder="Date Of Birth">
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="age" name="age" placeholder="Age" readonly>
              </div>
              <div class="form-group">
                <label>Passing Year</label>
                <input class="form-control input-lg" type="date" id="passingyear" name="passingyear" placeholder="Passing Year">
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="qualification" name="qualification" placeholder="Highest Qualification">
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="stream" name="stream" placeholder="Stream">
              </div>
              <div class="form-group checkbox">
                <label><input type="checkbox"> I accept terms & conditions</label>
              </div>
              <div class="form-group">
                <button class="btn btn-flat btn-success">Register</button>
              </div>
            </div>
            <div class="col-md-6 latest-job ">
              <div class="form-group">
                <input class="form-control input-lg" type="password" id="password" name="password" placeholder="Password *" required>
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="password" id="cpassword" name="cpassword" placeholder="Confirm Password *" required>
              </div>
              <div id="passwordError" class="btn btn-flat btn-danger hide-me" >
                    Password Mismatch!!
                  </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="contactno" name="contactno" minlength="10" maxlength="10" onkeypress="return validatePhone(event);" placeholder="Phone Number">
              </div>
              <div class="form-group">
                <textarea class="form-control input-lg" rows="4" id="address" name="address" placeholder="Address"></textarea>
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="city" name="city" placeholder="City">
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="state" name="state" placeholder="State">
              </div>
              <div class="form-group">
                <textarea class="form-control input-lg" rows="4" id="skills" name="skills" placeholder="Enter Skills"></textarea>
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" id="designation" name="designation" placeholder="Designation">
              </div>

              <div class="form-group">
                <label>Upload Resume</label> <span class="label label-danger">File Format PDF Only!</span>
                <input type="file" name="resume" class="btn btn-flat btn-default" required>
              </div>
            </div>
            <?php
              //If User already registered with this email then show error message.
              if(isset($_SESSION['registerError'])) {
                ?>
                <div class="row col-md-12">
                  <p class="text-danger text-center">Email Already Exists! Choose A Different Email!</p>
                </div>
              <?php
               unset($_SESSION['registerError']);
              }
              ?>

              <?php if(isset($_SESSION['uploadError'])) { ?>
              <div class="row col-md-12">
                  <p class="text-danger text-center"><?php echo $_SESSION['uploadError']; ?></p>
              </div>
              <?php unset($_SESSION['uploadError']);
            } ?>
          </form>
          
        </div>
      </div>
    </section>

    

  </div>
  <!-- /.content-wrapper -->
<?php include_once 'inc/footer.php'; ?>

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
</script>

<script type="text/javascript">
  $('#dob').on('change', function() {
    var today = new Date();
    var birthDate = new Date($(this).val());
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();

    if(m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    $('#age').val(age);
  });
</script>
<script>
  $("#registerCandidates").on("submit", function(e) {
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
