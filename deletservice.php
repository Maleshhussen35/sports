<?php
include_once("includes/connection.php");

$club_id = $_GET['club_id'];
$error_message = "";

// Delete the record
if ($club_id) {
    // $stmt = $conn->prepare("DELETE FROM club_services WHERE club_id = ?");
    $stmt = $conn->prepare("UPDATE club_services SET club_del='absent' WHERE club_id = ?");
    $stmt->bind_param("i", $club_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('Record deleted successfully.');
        window.location.href = 'club-services.php';
      </script>";
      exit();
    } else {
        echo "<script>
        alert('Error: Could not delete the staff record.');
        window.location.href = 'club-services.php';
      </script>";
    }
    $stmt->close();
}
$conn->close();
?>
