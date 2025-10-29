<header class="main-header">
  <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
      <!-- Logo and toggle -->
      <div class="navbar-header">
        <!-- Mobile menu toggle button -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!-- Logo -->
        <a href="index.php" class="navbar-brand">
          <b>Job</b> Portal
        </a>
      </div>

      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="jobs.php">Jobs</a></li>

          <?php if(empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="sign-up.php">Sign Up</a></li>
          <?php } else {
            if(isset($_SESSION['id_user'])) { ?>
              <li><a href="user/index.php">Dashboard</a></li>
            <?php } elseif(isset($_SESSION['id_company'])) { ?>
              <li><a href="company/index.php">Dashboard</a></li>
            <?php } ?>
            <li><a href="logout.php">Logout</a></li>
          <?php } ?>
        </ul>
      </div>

    </div>
  </nav>
</header>
