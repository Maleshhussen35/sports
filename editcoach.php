<?php
include_once("includes/connection.php");
$error_message = $success_message = "";

// Check if staff_id is provided
if (isset($_GET['coach_id'])) {
    $coach_id = $_GET['coach_id'];

    // Fetch the staff details from the database
    $query = mysqli_query($conn, "SELECT * FROM coaches WHERE coach_id ='$coach_id'");
    $staff = mysqli_fetch_array($query);

    // If form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $coach_name = trim($_POST['coach_name']);
        $position = trim($_POST['position']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
            // Update the staff details in the database
            $updateQuery = mysqli_query($conn, "UPDATE coaches SET coach_name = '$coach_name', 	professionalism = '$position', email = '$email', phone = '$phone' WHERE coach_id = '$coach_id'");

            if ($updateQuery) {
                echo "<script>
                alert('Coach details updated successfully..');
                window.location.href = 'coaches-lists.php';
              </script>";
             exit();
                // $success_message = "Staff details updated successfully.";
            } else {
                $error_message = "An error occurred while updating staff details.";
            }
       
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Staff</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h3>Edit Coach</h3>
    
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

    <form method="POST">
      <div class="form-group">
        <label for="staffName">Coach Name</label>
        <input type="text" class="form-control" id="staffName" name="coach_name" value="<?php echo $staff['coach_name']; ?>" required>
      </div>
      <div class="form-group">
        <label for="staffEmail">Email</label>
        <input type="email" class="form-control" id="staffEmail" name="email" value="<?php echo $staff['email']; ?>" required>
      </div>
      <div class="form-group">
        <label for="staffPhone">Phone</label>
        <input type="tel" class="form-control" id="staffPhone" name="phone" value="<?php echo $staff['phone']; ?>" required 
               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)">
        <small id="phoneError" class="text-danger"></small>
      </div>
      <div class="form-group">
        <label for="staffPosition">Proffesionalism</label>
        <input type="text" class="form-control" id="staffPosition" name="position" value="<?php echo $staff['professionalism']; ?>" required>
      </div>
      
      
      <button type="submit" class="btn btn-primary">Update Staff</button>
    </form>
  </div>
  <script>
    function validatePhoneNumber() {
      let phoneInput = document.getElementById("staffPhone").value;
      let phoneError = document.getElementById("phoneError");

      if (phoneInput.length !== 10) {
        phoneError.textContent = "Phone number must be exactly 10 digits.";
        return false;
      } else {
        phoneError.textContent = "";
        return true;
      }
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
