<?php
include_once("includes/connection.php");

// Initialize message variables
$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $age = (int)$_POST['age'];
    $club = (int)$_POST['club'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Validate form fields
    if ($password !== $cpassword) {
        $error_message = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $query = "INSERT INTO coaches (firstname, lastname, email, phone, age, club_id, password) VALUES ('$firstname', '$lastname', '$email', '$phone', $age, $club, '$hashed_password')";

        if (mysqli_query($conn, $query)) {
            $success_message = "Coach added successfully!";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
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
    .home-2{
      background:whitesmoke;
    }
    .actives {
        background: whitesmoke;
    }
  </style>
</head>
<body>
<?php include_once("includes/topbar.php");?>
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
          <h3>Coach addition Form</h3>
          <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#addStaffModal">New Coach</button> -->
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
        <div class="mb-3">
          <input type="text" id="searchInput" class="form-control" placeholder="Search Member...">
        </div>

        <!-- Staff Table -->
        <table class="table table-bordered" id="staffTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Club Name</th>
              <th>Professionalism</th>
            </tr>
          </thead>
          <tbody>
          <?php
    $cnt=1;
      $dis = mysqli_query($conn,"select * from coaches join club_services on coaches.club_id=club_services.club_id");
      while($rows=mysqli_fetch_array($dis)){
        $coach_id = $rows['coach_id'];
        ?>
            <tr>
                <td class="text-center"><?php echo $cnt;?></td>
                 <td><?php echo $rows['coach_name']?> </td>
                 <td><?php echo $rows['email'] ?></td>
                 <td><?php echo $rows['phone'] ?></td>
                 <td><?php echo $rows['name'] ?></td>
                 <td><?php echo $rows['professionalism'] ?></td>
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
          <h5 class="modal-title" id="addStaffModalLabel">New Coach Form Entry</h5>
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
    <input type="number" class="form-control" id="memberPhone" name="phone" required>
  </div>
  <div class="form-group">
    <label for="memberAge">Age</label>
    <input type="number" class="form-control" id="memberAge" name="age" required>
  </div>
  <div class="form-group">
    <label for="club">Club to Train</label>
    <select name="club" id="" class="form-control" required>
      <option value="">~~ Select Club to Join ~~</option>
      <?php  
       $club = mysqli_query($conn, "SELECT * FROM club_services");
       while($clubb = mysqli_fetch_array($club)) {
        ?>
        <option value="<?php echo $clubb['club_id']; ?>"><?php echo $clubb['name']; ?></option>
        <?php
       }
      ?>
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
  <button type="submit" class="btn btn-primary">Add Coach</button>
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
