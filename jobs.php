<?php
//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");
include_once 'inc/header.php';
?>

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <?php include_once 'inc/navbar.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">
    <section class="content-header">
      <div class="container">
        <div class="row">
          <h1 class="text-center">Latest Jobs</h1>
           <div class="col-md-3 latest-job margin-top-50">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Filters</h3>
              </div>
              <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked tree" data-widget="tree">
                  <li class="treeview menu-open">
                    <a href="#"><i class="fa fa-plane text-red"></i> City <span class="pull-right">
                      <i class="fa fa-angle-down pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <?php
                        $sql1 = "SELECT city FROM company GROUP BY city";
                        $result1 = $conn->query($sql1);
                        if ($result1 && $result1->num_rows > 0) {
                            while ($row = $result1->fetch_assoc()) {
                                $cityName = htmlspecialchars($row['city'], ENT_QUOTES, 'UTF-8');
                                ?>
                                <li>
                                  <label style="display:block; padding:6px 10px; cursor:pointer;">
                                    <input type="checkbox" class="cityCheckbox" value="<?php echo $cityName; ?>">
                                    &nbsp; <span class="cityName text-muted"><?php echo $cityName; ?></span>
                                  </label>
                                </li>
                                <?php
                            }
                        }
                      ?>
                    </ul>
                  </li>
                  <li class="treeview menu-open">
                    <a href="#"><i class="fa fa-plane text-red"></i> Experience <span class="pull-right">
                      <i class="fa fa-angle-down pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <?php for ($e = 1; $e <= 5; $e++) { ?>
                      <li>
                        <label style="display:block; padding:6px 10px; cursor:pointer;">
                          <input type="radio" name="experience" class="experienceRadio" value="<?php echo $e; ?>">
                          &nbsp; <span class="experienceName text-muted"> > <?php echo $e; ?> Years</span>
                        </label>
                      </li>
                      <?php } ?>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-9 latest-job margin-top-50 margin-bottom-20">
            <div class="input-group input-group-lg margin-bottom-20">
                <input type="text" id="searchBar" class="form-control" placeholder="Search job">
                <span class="input-group-btn">
                  <button id="searchBtn" type="button" class="btn btn-info btn-flat">Go!</button>
                </span>
            </div>
            <?php $limit = 4;
              $sql = "SELECT COUNT(id_jobpost) AS id FROM job_post";
              $result = $conn->query($sql);
              $total_records = 0;
              $total_pages = 0;
              if($result && $result->num_rows > 0)
              {
                $row = $result->fetch_assoc();
                $total_records = (int) $row['id'];
                if ($total_records > 0) {
                  $total_pages = ceil($total_records / $limit);
                } else {
                  $total_pages = 0;
                }
              }
            ?>
            <div id="target-content"></div>
            <div class="text-center">
              <ul class="pagination text-center" id="pagination"></ul>
            </div>
            <script>
              var initialCount = <?php echo json_encode($total_records); ?>;
              var initialTotalPages = <?php echo json_encode($total_pages); ?>;
            </script>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

<?php include_once 'inc/footer.php'; ?>

<script>
  function initPagination(pages) {
    if (!pages || pages <= 0) {
      $('#pagination').hide();
      return;
    }
    $('#pagination').show();
    $("#pagination").twbsPagination({
      totalPages: pages,
      visible: 5,
      onPageClick: function (e, page) {
        e.preventDefault();
        $("#target-content").html("loading....");
        $("#target-content").load("search.php?page="+page);
      }
    });
  }

  $(function () {
    initPagination(typeof initialTotalPages !== 'undefined' ? initialTotalPages : 1);
    // city checkbox multi-select handler
    $(document).on('change', '.cityCheckbox', function (e) {
      var selected = [];
      $('.cityCheckbox:checked').each(function () {
        selected.push($(this).val());
      });

      try { $('#pagination').twbsPagination('destroy'); } catch (err) {}
      if (selected.length > 0) {
        // join with comma; Search will encode value before sending
        Search(selected.join(','), 'city');
      } else {
        initPagination(typeof initialTotalPages !== 'undefined' ? initialTotalPages : 1);
      }
    });
  });

  $("#searchBtn").on("click", function(e) {
    e.preventDefault();
    var searchResult = $("#searchBar").val();
    var filter = "searchBar";
    try { $('#pagination').twbsPagination('destroy'); } catch (err) {}
    if(searchResult != "") {
      Search(searchResult, filter);
    } else {
      initPagination(typeof initialTotalPages !== 'undefined' ? initialTotalPages : 1);
    }
  });

  // experience radio single-select handler
  $(document).on('change', '.experienceRadio', function (e) {
    var searchResult = $(this).val();
    var filter = 'experience';
    try { $('#pagination').twbsPagination('destroy'); } catch (err) {}
    if (searchResult != '') {
      Search(searchResult, filter);
    } else {
      initPagination(typeof initialTotalPages !== 'undefined' ? initialTotalPages : 1);
    }
  });

  $(".citySearch").on("click", function(e) {
    e.preventDefault();
    var searchResult = $(this).data("target");
    var filter = "city";
    try { $('#pagination').twbsPagination('destroy'); } catch (err) {}
    if(searchResult != "") {
      Search(searchResult, filter);
    } else {
      initPagination(typeof initialTotalPages !== 'undefined' ? initialTotalPages : 1);
    }
  });

  function Search(val, filter) {
    // first request count for the given filter so pagination reflects filtered results
    val = encodeURIComponent(val);
    $.get("search.php?action=count&filter="+filter+"&search="+val, function(countStr) {
      var count = parseInt(countStr, 10) || 0;
      if (count === 0) {
        $("#target-content").html('<div class="text-center">No records found</div>');
        $('#pagination').hide();
        return;
      }
      $('#pagination').show();
      var totalPages = Math.ceil(count / <?php echo $limit; ?>);
      initPagination(totalPages);
      // load first page of filtered results
      $("#target-content").html("loading....");
      $("#target-content").load("search.php?page=1&search="+val+"&filter="+filter);
    });
  }
</script>
</body>
</html>
