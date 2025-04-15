<?php
include_once("includes/connection.php"); // Ensure this file correctly sets up $conn

$error_message = $success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data (Basic validation)
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $goal = trim($_POST['goal']);

    // Check if form inputs are not empty
    if (!empty($name) && !empty($position) && !empty($goal)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO club_services (name, position, goal) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $name, $position, $goal);

            // Execute the statement
            if ($stmt->execute()) {
                $success_message = "New record created successfully.";
            } else {
                $error_message = "Sorry, an error occurred: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $error_message = "Failed to prepare the SQL statement.";
        }
    } else {
        $error_message = "All fields are required.";
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
          <h3>Our Club-Services</h3>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addStaffModal"> Add Club Service</button>
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
          <input type="text" id="searchInput" class="form-control" placeholder="Search Club Service...">
        </div>

        <!-- Staff Table -->
        <table class="table table-bordered" id="staffTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Club Name</th>
            <th>Club Target</th>
            <th>Club Goal</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td class="text-center"><?php echo $cnt; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['position']); ?></td>
                <td><?php echo htmlspecialchars($row['goal']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td>
                    <a class="btn btn-warning btn-sm" href="editservice.php?club_id=<?php echo $row['club_id']; ?>">Edit</a>
                    <a class="btn btn-danger btn-sm" href="deletservice.php?club_id=<?php echo $row['club_id']; ?>" onclick="return confirm('Are you sure you want to delete this Club?')">Delete</a>
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
          <h5 class="modal-title" id="addStaffModalLabel">Add Club Service</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="POST">
  <div class="form-group">
    <label for="clubName">Club Name</label>
    <input type="text" class="form-control" id="clubName" name="name" required>
  </div>
  <div class="form-group">
    <label for="ClubTarget">Club Target</label>
    <input type="text" class="form-control" id="ClubTarget" name="position" required>
  </div>
  <div class="form-group">
    <label for="goal">Club Future Goal</label>
    <textarea name="goal" id="goal" class="form-control">
    </textarea>
  </div>
  <button type="submit" class="btn btn-primary">Add Club</button>
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
