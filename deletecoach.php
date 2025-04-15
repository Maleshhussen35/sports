<?php
include_once("includes/connection.php");

$coach_id= $_GET['coach_id'];
$error_message = "";

// Delete the record
if ($coach_id) {
    $stmt = $conn->prepare("DELETE FROM coaches WHERE coach_id = ?");
    // $stmt = $conn->prepare("UPDATE plans SET plan_del='absent' WHERE coach_id = ?");
    $stmt->bind_param("i", $coach_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('Record deleted successfully.');
        window.location.href = 'coaches-lists.php';
      </script>";
      exit();
    } else {
        echo "<script>
        alert('Error: Could not delete the plan record.');
        window.location.href = 'coaches-lists.php';
      </script>";
    }
    $stmt->close();
}
$conn->close();
?>
