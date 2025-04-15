<?php
include_once("includes/connection.php");
$error_message = $success_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']);
    $encryptancy = base64_encode($password);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } 
    // Check if passwords match
    elseif ($password !== $cpassword) {
        $error_message = "Password and Confirm do not match!";
    } 
    else {
        // Check if email already exists in the database
        $checkEmailQuery = mysqli_query($conn, "SELECT * FROM staff WHERE email = '$email'");
        if (mysqli_num_rows($checkEmailQuery) > 0) {
            $error_message = "Email already exists in the database!";
        } else {
            // Insert into database
            $insert = mysqli_query($conn, "INSERT INTO staff (name, position, email, phone, password) VALUES ('$name', '$position', '$email', '$phone', '$encryptancy')");
            if ($insert) {
                $success_message = "Staff added successfully.";
            } else {
                $error_message = "Sorry, an error occurred.";
            }
        }
    }
}
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
    .home-6{
      background:whitesmoke;
    }
    .actives {
        background: whitesmoke;
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <a class="navbar-brand" href="#">Sports Club Management (Admin Panel)</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <button class="btn btn-danger"><a href="login.php" style="color:white;">Logout</a></button>
        </li>
      </ul>
    </div>
  </nav>

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
          <h3>Members Lists</h3>
          <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#addStaffModal">Add Staff</button> -->
        </div>
        <?php if ($error_message): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
        <!-- Search and Filter Section -->
        <div class="mb-3">
          <input type="text" id="searchInput" class="form-control" placeholder="Search Member...">
        </div>

        <!-- Staff Table -->
        <table class="table table-bordered" id="staffTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Age</th>
              <th>Club Name</th>
              <th>Plan Enrolled</th>
              <th>Training Time</th>
            </tr>
          </thead>
          <tbody>
          <?php
    $cnt=1;
      $dis = mysqli_query($conn,"select * from members join club_services on members.club_id= club_services.club_id join plans on members.plan_id=plans.plan_id");
      while($rows=mysqli_fetch_array($dis)){
        $member_id = $rows['member_id'];
        ?>
            <tr>
                <td class="text-center"><?php echo $cnt;?></td>
                 <td><?php echo $rows['firstname'] . " ".$rows['lastname'] ?> </td>
                 <td><?php echo $rows['email'] ?></td>
                 <td><?php echo $rows['phone'] ?></td>
                 <td><?php echo $rows['age'] ?></td>
                 <td><?php echo $rows['name'] ?></td>
                 <td><?php echo $rows['planname'] ?></td>
                 <td><?php echo $rows['training_time'] ?></td>
            </tr>
        <?php
        $cnt=$cnt+1;
      }
    ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add Staff Modal -->
  <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addStaffModalLabel">Add New Staff</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="POST">
  <div class="form-group">
    <label for="staffName">Name</label>
    <input type="text" class="form-control" id="staffName" name="name" required>
  </div>
  <div class="form-group">
    <label for="staffPosition">Position</label>
    <input type="text" class="form-control" id="staffPosition" name="position" required>
  </div>
  <div class="form-group">
    <label for="staffEmail">Email</label>
    <input type="email" class="form-control" id="staffEmail" name="email" required>
  </div>
  <div class="form-group">
    <label for="staffPhone">Phone</label>
    <input type="tel" class="form-control" id="staffPhone" name="phone" required>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <div class="form-group">
    <label for="cpassword">Confirm Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword" required>
  </div>
  <button type="submit" class="btn btn-primary">Add Staff</button>
</form>

        </div>
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
