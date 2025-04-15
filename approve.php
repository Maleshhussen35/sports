<?php
include_once("includes/connection.php");

// Check if staff_id is provided
if (isset($_GET['member_id'])) {
    $member_id = $_GET['member_id'];

    // Delete the staff record from the database
    $deleteQuery = mysqli_query($conn, "update members set meStatus='Approved' where member_id='$member_id'");

    if ($deleteQuery) {
        // Redirect with a success message
        echo "<script>
                alert('Members Appliction approved successfully.');
                window.location.href ='memberlist.php';
              </script>";
        exit();
    } else {
        // Display error message using alert
        echo "<script>
                alert('Error: Could not delete the staff record.');
                window.location.href ='memberlist.php';
              </script>";
    }
} else {
    // Display error if staff_id is not provided
    echo "<script>
            alert('Member ID not provided.');
            window.location.href = 'memberlist.php';
          </script>";
}
?>
