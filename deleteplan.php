<?php
include_once("includes/connection.php");

$plan_id = $_GET['plan_id'];
$error_message = "";

// Delete the record
if ($plan_id) {
    // $stmt = $conn->prepare("DELETE FROM club_services WHERE club_id = ?");
    $stmt = $conn->prepare("UPDATE plans SET plan_del='absent' WHERE plan_id = ?");
    $stmt->bind_param("i", $plan_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('Record deleted successfully.');
        window.location.href = 'plan-fees.php';
      </script>";
      exit();
    } else {
        echo "<script>
        alert('Error: Could not delete the plan record.');
        window.location.href = 'club-services.php';
      </script>";
    }
    $stmt->close();
}
$conn->close();
?>
