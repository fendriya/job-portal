<?php

session_start();

require_once("db.php");

$limit = 4;

if(isset($_GET["page"])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

$start_from = ($page-1) * $limit;

// default SQL: paginated job posts (used when no filter is provided)
$sql = "SELECT * FROM job_post Order By id_jobpost DESC LIMIT $start_from, $limit";

// If caller only wants the total count for a given filter (used by pagination)
if (isset($_GET['action']) && $_GET['action'] === 'count') {
  $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
  // decode once (client sends encoded value)
  $searchRaw = isset($_GET['search']) ? urldecode($_GET['search']) : '';

  if ($filter === 'city') {
    // support multiple comma-separated cities
    $cities = array_filter(array_map('trim', explode(',', $searchRaw)));
    if (count($cities) > 0) {
      $escaped = array();
      foreach ($cities as $c) {
        $escaped[] = "'" . $conn->real_escape_string($c) . "'";
      }
      $in = implode(',', $escaped);
      $countSql = "SELECT COUNT(j.id_jobpost) AS cnt FROM job_post j JOIN company c ON j.id_company=c.id_company
      WHERE c.city IN ($in)";
    } else {
      $countSql = "SELECT COUNT(id_jobpost) AS cnt FROM job_post";
    }
  } elseif ($filter === 'searchBar') {
    $countSql = "SELECT COUNT(id_jobpost) AS cnt FROM job_post WHERE jobtitle LIKE '%$search%'";
  } elseif ($filter === 'experience') {
    $exp = (int) $search;
    $countSql = "SELECT COUNT(id_jobpost) AS cnt FROM job_post WHERE experience>='$exp'";
  } else {
    $countSql = "SELECT COUNT(id_jobpost) AS cnt FROM job_post";
  }

  $res = $conn->query($countSql);
  $count = 0;
  if ($res && $res->num_rows > 0) {
    $r = $res->fetch_assoc();
    $count = (int) $r['cnt'];
  }
  echo $count;
  $conn->close();
  exit;
}

if (isset($_GET['filter']) && $_GET['filter'] === 'city') {
  // Use a single JOINed query so LIMIT and offset apply to the whole result set
  $cityRaw = isset($_GET['search']) ? urldecode($_GET['search']) : '';
  $cities = array_filter(array_map('trim', explode(',', $cityRaw)));
  if (count($cities) > 0) {
    $escaped = array();
    foreach ($cities as $c) {
      $escaped[] = "'" . $conn->real_escape_string($c) . "'";
    }
    $in = implode(',', $escaped);
    $sql = "SELECT j.*, c.logo, c.companyname, c.city FROM job_post j JOIN company c ON j.id_company = c.id_company
    WHERE c.city IN ($in) ORDER BY j.id_jobpost DESC LIMIT $start_from, $limit";
  } else {
    $sql = "SELECT j.*, c.logo, c.companyname, c.city FROM job_post j JOIN company c ON j.id_company = c.id_company
    ORDER BY j.id_jobpost DESC LIMIT $start_from, $limit";
  }
  $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="attachment-block clearfix">
                <img class="attachment-img" src="uploads/logo/<?php echo $row['logo']; ?>" alt="Company logo">
                <div class="attachment-pushed">
                    <h4 class="attachment-heading">
                      <a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                        <?php echo $row['jobtitle']; ?>
                      </a>
                      <span class="attachment-heading pull-right">$<?php echo $row['maximumsalary']; ?>/Month</span>
                    </h4>
                    <div class="attachment-text">
                        <div>
                          <strong>
                            <?php echo $row['companyname']; ?> | <?php echo $row['city']; ?> | Experience
                            <?php echo $row['experience']; ?>
                            Years
                          </strong>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
} else {
    // other filters: searchBar or experience
    if (isset($_GET['filter']) && $_GET['filter'] === 'searchBar') {
        $search = $conn->real_escape_string(isset($_GET['search']) ? $_GET['search'] : '');
        $sql = "SELECT * FROM job_post WHERE jobtitle LIKE '%$search%' LIMIT $start_from, $limit";
    } elseif (isset($_GET['filter']) && $_GET['filter'] === 'experience') {
        $exp = (int) (isset($_GET['search']) ? $_GET['search'] : 0);
        $sql = "SELECT * FROM job_post WHERE experience>='$exp' LIMIT $start_from, $limit";
    }

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $company_id = $conn->real_escape_string($row['id_company']);
            $sql1 = "SELECT * FROM company WHERE id_company='$company_id'";
            $result1 = $conn->query($sql1);
            if ($result1 && $result1->num_rows > 0) {
                while ($row1 = $result1->fetch_assoc()) {
                    ?>
                    <div class="attachment-block clearfix">
                        <img class="attachment-img" src="uploads/logo/<?php echo $row1['logo']; ?>" alt="Company logo">
                        <div class="attachment-pushed">
                            <h4 class="attachment-heading">
                              <a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                                <?php echo $row['jobtitle']; ?>
                              </a>
                              <span class="attachment-heading pull-right">$<?php echo $row['maximumsalary']; ?>
                                /Month
                              </span>
                            </h4>
                            <div class="attachment-text">
                                <div>
                                  <strong>
                                    <?php echo $row1['companyname']; ?> | <?php echo $row1['city']; ?> | Experience
                                    <?php echo $row['experience']; ?>
                                    Years
                                  </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
    }
}
$conn->close();
