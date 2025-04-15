<?php
include_once("includes/connection.php");

$error_message = $success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $coach_name = mysqli_real_escape_string($conn, trim($_POST['coach']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $professionalism = mysqli_real_escape_string($conn, trim($_POST['proff']));
    $club_id = mysqli_real_escape_string($conn, trim($_POST['club']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, trim($_POST['cpassword']));
    $encryptancy = base64_encode($password);

    // Ensure all fields are filled
    if (!preg_match('/^\d{10}$/', $phone)) {
      die("<script>alert('Invalid phone number! Enter exactly 10 digits.'); window.history.back();</script>");
     }
     elseif($password != $cpassword){
      $error_message = "Sorry! Password and Confirm password do not match.";
     }elseif(!empty($coach_name) && !empty($phone) && !empty($email) && !empty($professionalism) && !empty($club_id)) {
        
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO coaches (coach_name, phone, email, professionalism, club_id,password) VALUES (?, ?, ?, ?, ?,?)");
        $stmt->bind_param("ssssis", $coach_name, $phone, $email, $professionalism, $club_id, $encryptancy);
        
        // Execute and check for success
        if ($stmt->execute()) {
            $success_message = "Coach added successfully.";
        } else {
            $error_message = "Error adding coach: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        $error_message = "All fields are required.";
    }
}

// Fetch coaches from the database
$cnt = 1;
$dis = mysqli_query($conn, "SELECT * FROM coaches");
$rows = [];
while ($row = mysqli_fetch_array($dis)) {
    $rows[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sports Club Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .dashboard-card {
      background-color: #f8f9fa;
      margin-top: 20px;
    }
    .home-5{
      background:whitesmoke;
    }
    .actives {
        background: whitesmoke;
    }
  </style>
</head>
<body>
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

  <div class="container mt-4">
  </div>

  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-md-3">
        <?php include_once("includes/sidebar.php"); ?>
      </div>
      
      <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3>Coaches Lists</h3>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addCoachModal">Add Coach</button>
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
        
        <div class="mb-3">
          <input type="text" id="searchInput" class="form-control" placeholder="Search coach...">
        </div>

        <table class="table table-bordered" id="coachTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Coach Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Professionalism</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td class="text-center"><?php echo $cnt; ?></td>
                <td><?php echo htmlspecialchars($row['coach_name']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['professionalism']); ?></td>
                <td>
                    <a class="btn btn-warning btn-sm" href="editcoach.php?coach_id=<?php echo $row['coach_id']; ?>">Edit</a>
                    <a class="btn btn-danger btn-sm" href="deletecoach.php?coach_id=<?php echo $row['coach_id']; ?>" onclick="return confirm('Are you sure you want to delete this Coach?')">Delete</a>
                </td>
            </tr>
            <?php $cnt++; ?>
        <?php endforeach; ?>
    </tbody>
</table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addCoachModal" tabindex="-1" role="dialog" aria-labelledby="addCoachModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCoachModalLabel">Add New Coach</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="form-group">
        <label for="coachName">Coach Name</label>
        <input type="text" class="form-control" id="coachName" name="coach" required>
    </div>
    
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" id="phone" name="phone" 
               pattern="\d{10}" maxlength="10" minlength="10"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
               required>
        <small class="text-muted">Enter a 10-digit phone number.</small>
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    
    <div class="form-group">
        <label for="proff">Professionalism</label>
        <input type="text" class="form-control" id="proff" name="proff" required>
    </div>
    
    <div class="form-group">
        <label for="club">Assign Club</label>
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
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="cpassword">Confirm password</label>
        <input type="password" class="form-control" id="cpassword" name="cpassword" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Add Coach</button>
</form>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("includes/footer.php"); ?>
</body>
</html>
