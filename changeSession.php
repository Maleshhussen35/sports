<?php
include_once("includes/connection.php"); // Ensure this file correctly sets up $conn

$error_message = $success_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate form data (Basic validation)
  $training = trim($_POST['training']);
  $member_id = trim($_POST['member_id']);

  // Check if member exists
  $sel = mysqli_query($conn, "SELECT * FROM members WHERE member_id='$member_id'");

  if (mysqli_num_rows($sel) > 0) {
      // Update training time
      $update = mysqli_query($conn, "UPDATE members SET training_time='$training' WHERE member_id='$member_id'");

      if ($update) {
          $success_message = "Booking session changed successfully.";
      } else {
          $error_message = "Sorry, an error occurred: " . mysqli_error($conn);
      }
  } else {
      $error_message = "Member not found.";
  }
}

// Fetch data from the database before closing the connection
$cnt = 1;
$dis = mysqli_query($conn, "SELECT * FROM club_services WHERE club_del='present'");
$rows = [];
while ($row = mysqli_fetch_array($dis)) {
    $rows[] = $row;
    $club_id = $row['club_id'];
}
//take Mmember details
$member_id = $_SESSION['member_id'];
$take = mysqli_query($conn,"select * from members where member_id='$member_id'");
$rotake = mysqli_fetch_array($take);
// Close the connection after completing all database operations
$conn->close();
?>
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
    .home-3{
      background:whitesmoke;
    }
    .actives {
        background: whitesmoke;
    }
  </style>
</head>
<body>
<?php  include_once("includes/topbar.php");?>
  <!-- Alert Section -->
  <div class="container mt-4">
 
  </div>

  <!-- Dashboard Section -->
  <div class="container-fluid mt-4">
    <div class="row">
      <!-- Sidebar (optional) -->
      <div class="col-md-3">
        <?php include_once("includes/sidebar.php"); ?>
      </div>
      
      <!-- Main Content -->
      <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3>Change Session</h3>
        </div>
        <?php
        if (!empty($error_message)) {
            echo '<div class="alert alert-danger">' . $error_message . '</div>';
        }
        if (!empty($success_message)) {
            echo '<div class="alert alert-success">' . $success_message . '</div>';
        }
        ?>
        <!-- Staff Table -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $rotake['email']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="username">Current Session Booked</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $rotake ['training_time']?>" readonly>
                </div>
                <div class="form-group">
                    <label for="trainingtime">Training Time</label>
                    <select name="training" class="form-control" required>
                      <option value="">~~ Select Training Time ~~</option>
                      <option value="Morning Session: 8:00am To 12:00pm">Morning Session: 8:00am To 12:00pm</option>
                      <option value="Afternoon Session: 1:00pm To 4:00pm">Afternoon Session: 1:00pm To 4:00pm</option>
                      <option value="Afternoon Session: 4:00pm To 8:00pm">Afternoon Session: 4:00pm To 8:00pm</option>
                    </select>
                 </div>
                 <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                  <div class="col-md-5">
                  <button type="submit" class="btn btn-primary btn-block">Change Session</button>
                  </div>
            </form>
      </div>
    </div>
  </div>
  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // Filter function
    document.getElementById('searchInput').addEventListener('input', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#staffTable tbody tr');
      
      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const matches = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
        row.style.display = matches ? '' : 'none';
      });
    });

    // Handle form submission
    document.getElementById('addStaffForm').addEventListener('submit', function(event) {
      event.preventDefault();
      // Logic to add new staff record to the table
      // ...
      $('#addStaffModal').modal('hide');
    });
  </script>

  <?php include_once("includes/footer.php"); ?>
</body>
</html>
