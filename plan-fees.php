<?php
include_once("includes/connection.php");

$error_message = $success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $planname = trim($_POST['planname']);
    $planLength = trim($_POST['planLength']);
    $fees = trim($_POST['fees']);
    $planend = trim($_POST['planend']);
    
    if (!empty($planname) && !empty($planLength) && !empty($fees) && !empty($planend)) {
        $stmt = $conn->prepare("INSERT INTO plans (planname, planLength, fees, planend) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $planname, $planLength, $fees, $planend);
        
        if ($stmt->execute()) {
            $success_message = "Plan created successfully.";
        } else {
            $error_message = "Error creating plan: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        $error_message = "All fields are required.";
    }
}

// Fetch data from the database before closing the connection
$cnt = 1;
$dis = mysqli_query($conn, "SELECT * FROM plans WHERE plan_del='present'");
$rows = [];
while ($row = mysqli_fetch_array($dis)) {
    $rows[] = $row;
    $plain_id = $row['plan_id'];
}

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
    .home-4{
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
          <h3>Our Plans & Fees Charges</h3>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addStaffModal">Add Plan</button>
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
          <input type="text" id="searchInput" class="form-control" placeholder="Search plan...">
        </div>

        <!-- Staff Table -->
        <table class="table table-bordered" id="staffTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Plan Name</th>
            <th>Plan Length</th>
            <th>Fees to be Charged</th>
            <th>Plan end Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td class="text-center"><?php echo $cnt; ?></td>
                <td><?php echo htmlspecialchars($row['planname']); ?></td>
                <td><?php echo htmlspecialchars($row['planLength']); ?></td>
                <td><?php echo htmlspecialchars($row['fees']); ?></td>
                <td><?php echo htmlspecialchars($row['planend']); ?></td>
                <td>
                    <a class="btn btn-warning btn-sm" href="editplan.php?plan_id=<?php echo $row['plan_id']; ?>">Edit</a>
                    <a class="btn btn-danger btn-sm" href="deleteplan.php?plan_id=<?php echo $row['plan_id']; ?>" onclick="return confirm('Are you sure you want to delete this Plan?')">Delete</a>
                </td>
            </tr>
            <?php $cnt++; ?>
        <?php endforeach; ?>
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
          <h5 class="modal-title" id="addStaffModalLabel">Create New Plan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label for="planName">Plan Name</label>
            <input type="text" class="form-control" id="planName" name="planname" required>
        </div>
        <div class="form-group">
            <label for="planLength">Plan Length</label>
            <input type="text" class="form-control" id="planLength" name="planLength" required>
        </div>
        <div class="form-group">
            <label for="feescharged">Fees to be Charged</label>
            <input type="number" class="form-control" id="feescharged" name="fees" required>
        </div>
        <div class="form-group">
            <label for="planend">Plan End</label>
            <input type="text" class="form-control" id="planend" name="planend" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Plan</button>
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
