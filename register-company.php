<?php
session_start();

if(isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) {
  header("Location: index.php");
  exit();
}

require_once("db.php");
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
          <h1 class="text-center margin-bottom-20">CREATE COMPANY PROFILE</h1>
          <form method="post" id="registerCompanies" action="addcompany.php" enctype="multipart/form-data">
            <div class="col-md-6 latest-job ">
              <div class="form-group">
                <input class="form-control input-lg" type="text" name="name" placeholder="Full Name" required>
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" name="companyname" placeholder="Company Name" required>
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" name="website" placeholder="Website">
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" name="email" placeholder="Email" required>
              </div>
              <div class="form-group">
                <textarea class="form-control input-lg" rows="4" name="aboutme" placeholder="Brief info about your company"></textarea>
              </div>
              <div class="form-group checkbox">
                <label><input type="checkbox" required> I accept terms & conditions</label>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-flat btn-success">Register</button>
              </div>
            </div>
            <div class="col-md-6 latest-job ">
              <div class="form-group">
                <input class="form-control input-lg" type="password" name="password" placeholder="Password" required>
              </div>
              <div class="form-group">
                <input class="form-control input-lg" type="password" name="cpassword" placeholder="Confirm Password" required>
              </div>
               <div id="passwordError" class="btn btn-flat btn-danger hide-me" >
                    Password Mismatch!!
                  </div>
              <div class="form-group">
                <input class="form-control input-lg" type="text" name="contactno" placeholder="Phone Number" minlength="10" maxlength="10" autocomplete="off" onkeypress="return validatePhone(event);" required>
              </div>
              <div class="form-group">
                <select class="form-control  input-lg" id="country" name="country" required>
                <option selected="" value="">Select Country</option>
                <?php
                  $sql="SELECT * FROM countries";
                  $result=$conn->query($sql);
                  if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      echo "<option value='".$row['name']."' data-id='".$row['id']."'>".$row['name']."</option>";
                    }
                  }
                ?>
                </select>
              </div>
              <div id="stateDiv" class="form-group" style="display: none;">
                <select class="form-control  input-lg" id="state" name="state" required>
                  <option value="" selected="">Select State</option>
                </select>
              </div>
              <div id="cityDiv" class="form-group" style="display: none;">
                <select class="form-control  input-lg" id="city" name="city" required>
                  <option selected="">Select City</option>
                </select>
              </div>
              <div class="form-group">
                <label>Attach Company Logo</label>
                <input type="file" name="image" class="form-control input-lg" required>
              </div>
            </div>
            <?php
              //If Company already registered with this email then show error message.
              if(isset($_SESSION['registerError'])) {
                ?>
                <div class="row col-md-12">
                  <p class="text-center" style="color: red;">Email Already Exists! Choose A Different Email!</p>
                </div>
              <?php
               unset($_SESSION['registerError']); }
              ?>
              <?php
              if(isset($_SESSION['uploadError'])) {
                ?>
                <div class="row col-md-12">
                  <p class="text-center" style="color: red;"><?php echo $_SESSION['uploadError']; ?></p>
                </div>
              <?php
               unset($_SESSION['uploadError']); }
              ?>
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

<script>
  $("#country").on("change", function() {
    var id = $(this).find(':selected').attr("data-id");
    $("#state").find('option:not(:first)').remove();
    if(id != '') {
      $.post("state.php", {id: id}).done(function(data) {
        $("#state").append(data);
      });
      $('#stateDiv').show();
    } else {
      $('#stateDiv').hide();
      $('#cityDiv').hide();
    }
  });
</script>

<script>
  $("#state").on("change", function() {
    var id = $(this).find(':selected').attr("data-id");
    $("#city").find('option:not(:first)').remove();
    if(id != '') {
      $.post("city.php", {id: id}).done(function(data) {
        $("#city").append(data);
      });
      $('#cityDiv').show();
    } else {
      $('#cityDiv').hide();
    }
  });
</script>
<script>
  $("#registerCompanies").on("submit", function(e) {
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
