<?php
include_once("includes/connection.php");

$club_id = $_GET['club_id'];
$error_message = $success_message = "";

// Fetch the record to edit
if ($club_id) {
    $stmt = $conn->prepare("SELECT * FROM club_services WHERE club_id = ?");
    $stmt->bind_param("i", $club_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $club = $result->fetch_assoc();
    $stmt->close();
}

// Update the record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $goal = trim($_POST['goal']);

    if (!empty($name) && !empty($position) && !empty($goal)) {
        $stmt = $conn->prepare("UPDATE club_services SET name = ?, position = ?, goal = ? WHERE club_id = ?");
        $stmt->bind_param("sssi", $name, $position, $goal, $club_id);
        
        if ($stmt->execute()) {
            echo "<script>
            alert('Record updated successfully..');
            window.location.href = 'club-services.php';
          </script>";
        } else {
            $error_message = "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "All fields are required.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Club Service</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Club Service</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <form method="POST">
    <div class="form-group">
        <label for="name">Club Name:</label>
        <input type="text" id="name" class="form-control" name="name" value="<?php echo htmlspecialchars($club['name']); ?>" required>
    </div>
    <div class="form-group">
        <label for="position">Club Target:</label>
        <input type="text" id="position" class="form-control" name="position" value="<?php echo htmlspecialchars($club['position']); ?>" required>
    </div>

    <div class="form-group">
        <label for="goal">Club Goal:</label>
        <textarea id="goal" name="goal" class="form-control" required><?php echo htmlspecialchars($club['goal']); ?></textarea>
    </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
