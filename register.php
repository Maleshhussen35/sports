<?php
include_once("includes/connection.php");

// Initialize message variables
$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $age = (int)$_POST['age'];
    $club = (int)$_POST['club'];
    $plan = (int)$_POST['plan'];
    $training = mysqli_real_escape_string($conn, $_POST['training']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $seff = "Pending";

    // Validate phone number (10 digits)
    if (!preg_match('/^\d{10}$/', $phone)) {
        echo "<script>alert('Invalid phone number! Enter exactly 10 digits.'); window.history.back();</script>";
        exit();
    }

    // Check if passwords match
    if ($password !== $cpassword) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM members WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Email already exists! Please use a different email.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data into the database
$stmt = $conn->prepare("INSERT INTO members (firstname, lastname, email, phone, age, club_id, plan_id, training_time, password, meStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiiisss", $firstname, $lastname, $email, $phone, $age, $club, $plan, $training, $hashed_password, $seff);

            if ($stmt->execute()) {
                $success_message = "Member added successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
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
    .home-2{
      background:whitesmoke;
    }
    .actives {
        background: whitesmoke;
    }
  </style>
</head>
<body>
<?php //include_once("includes/topbar.php");?>
  <!-- Alert Section -->
  <div class="container mt-4">
 
  </div>

  <!-- Dashboard Section -->
  <div class="container-fluid mt-4">
    <div class="row">
      <!-- Sidebar (optional) -->
      <!-- <div class="col-md-3">
        <?php //include_once("includes/sidebar.php"); ?>
      </div> -->
      
      <!-- Main Content -->
      <div class="col-md-11">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3>Member Registration Form</h3>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addStaffModal">Register Now</button>
        </div>
        <?php
        // Display success or error messages
        if ($success_message) {
            echo "<div class='alert alert-success'>$success_message</div>";
        }
        if ($error_message) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
            
        <!-- Search and Filter Section -->
        <!-- <div class="mb-3">
          <input type="text" id="searchInput" class="form-control" placeholder="Search Member...">
        </div> -->

        <!-- Staff Table -->
    
      </div>
    </div>
  </div>

  <!-- Add Staff Modal -->
  <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addStaffModalLabel">Member Application Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
  <div class="form-group">
    <label for="firstName">First Name</label>
    <input type="text" class="form-control" id="firstName" name="firstname" required>
  </div>
  
  <div class="form-group">
    <label for="lastname">Last Name</label>
    <input type="text" class="form-control" id="lastname" name="lastname" required>
  </div>
  
  <div class="form-group">
    <label for="memberEmail">Email</label>
    <input type="email" class="form-control" id="memberEmail" name="email" required>
  </div>
  
  <div class="form-group">
    <label for="memberPhone">Phone</label>
    <input type="text" class="form-control" id="memberPhone" name="phone" 
           pattern="\d{10}" maxlength="10" minlength="10"
           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
           required>
    <small class="text-muted">Enter a 10-digit phone number.</small>
  </div>

  <div class="form-group">
    <label for="memberAge">Age</label>
    <input type="number" class="form-control" id="memberAge" name="age" required>
  </div>
  
  <div class="form-group">
    <label for="club">Club to Join</label>
    <select name="club" class="form-control" required>
      <option value="">~~ Select Club to Join ~~</option>
      <?php  
       $club = mysqli_query($conn, "SELECT * FROM club_services WHERE club_del='present'");
       while ($clubb = mysqli_fetch_array($club)) {
           echo "<option value='{$clubb['club_id']}'>{$clubb['name']}</option>";
       }
      ?>
    </select>
  </div>
  
  <div class="form-group">
    <label for="plan">Plan to Join</label>
    <select name="plan" class="form-control" required>
      <option value="">~~ Select Plan ~~</option>
      <?php  
       $plan = mysqli_query($conn, "SELECT * FROM plans WHERE plan_del='present'");
       while ($plann = mysqli_fetch_array($plan)) {
           echo "<option value='{$plann['plan_id']}'>{$plann['planname']}</option>";
       }
      ?>
    </select>
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
  
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  
  <div class="form-group">
    <label for="cpassword">Confirm Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword" required>
  </div>
  
  <button type="submit" class="btn btn-primary">Add Member</button>
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
