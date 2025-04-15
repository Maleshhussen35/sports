<?php
include_once("includes/connection.php");

// Check if staff_id is provided
if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    // Delete the staff record from the database
    $deleteQuery = mysqli_query($conn, "DELETE FROM staff WHERE staff_id = '$staff_id'");

    if ($deleteQuery) {
        // Redirect with a success message
        echo "<script>
                alert('Staff deleted successfully.');
                window.location.href = 'staff-lists.php';
              </script>";
        exit();
    } else {
        // Display error message using alert
        echo "<script>
                alert('Error: Could not delete the staff record.');
                window.location.href = 'staff-lists.php';
              </script>";
    }
} else {
    // Display error if staff_id is not provided
    echo "<script>
            alert('Staff ID not provided.');
            window.location.href = 'staff-lists.php';
          </script>";
}
?>
