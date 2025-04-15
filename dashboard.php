<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sports Club Management System</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom Styles -->
  <style>
    .dashboard-card {
      background-color: #f8f9fa;
      margin-top: 20px;
    }
    .actives{
        background:whitesmoke;
    }
    .home-1{
      background:whitesmoke;
    }
  </style>
</head>
<body>
<?php include_once("includes/topbar.php");?>
  <!-- Dashboard Section -->
  <div class="container-fluid mt-4">
    <div class="row">
      <!-- Sidebar (optional) -->
      <div class="col-md-3">
       <?php include_once("includes/sidebar.php");?>
      </div>

        <!-- Main Content --> 
        <div class="col-md-9">
        <!-- Dashboard Cards -->
        <div class="row">
          <!-- Card 1: Member Records -->
          <div class="col-md-4">
            <div class="card dashboard-card">
              <div class="card-body">
                <h5 class="card-title">Member Records</h5>
                <a href="memberlist.php" class="btn btn-primary">View Members</a>
              </div>
            </div>
          </div>
          
          <!-- Card 2: Booking System -->
          <div class="col-md-4">
            <div class="card dashboard-card">
              <div class="card-body">
                <h5 class="card-title">Members Lists</h5>
                <a href="memberlist.php" class="btn btn-primary">View Members</a>
              </div>
            </div>
          </div>

          <!-- Card 3: Reports -->
          <div class="col-md-4">
            <div class="card dashboard-card">
              <div class="card-body">
                <h5 class="card-title">Coaches Lists</h5>
                <a href="coachesLists.php" class="btn btn-primary">View Coaches</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Section: Staff Management -->
        <div class="row mt-4">
          <div class="col-md-6">
            <div class="card dashboard-card">
              <div class="card-body">
                <h5 class="card-title">Members Attendance</h5>
                <a href="memberAttendance.php" class="btn btn-primary">Manage Attendance</a>
              </div>
            </div>
          </div>

          <!-- Section: Club Services -->
       
        </div>
      </div>
    </div>
  </div>
 <?php include_once("includes/footer.php");?>
</body>
</html>
