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
    .actives1 {
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
          <h3>Available Sessions</h3>
        </div>
        <!-- Staff Table -->
        <table class="table table-bordered" id="staffTable">
    <thead>
        <tr>
            <th>Our Sessions Times</th>
        </tr>
    </thead>
    <tbody>
            <tr>
              <td>
                  <ol>
                    <li> Morning Session: 8:00am To 12:00pm </li>
                    <li> Afternoon Session: 1:00pm To 4:00pm</li>
                    <li> Afternoon Session: 4:00pm To 8:00pm </li>
                  </ol>
              </td>
            </tr>
    </tbody>
</table>
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
