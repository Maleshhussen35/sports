<?php
include_once("includes/connection.php");

$plan_id = $_GET['plan_id'];
$error_message = $success_message = "";

// Fetch the record to edit
if ($plan_id) {
    $stmt = $conn->prepare("SELECT * FROM plans WHERE plan_id = ?");
    $stmt->bind_param("i", $plan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $club = $result->fetch_assoc();
    $stmt->close();
}

// Update the record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $planname =trim($_POST['planname']);
    $planLength =trim($_POST['planLength']);
    $fees =trim($_POST['fees']);
    $planend =trim($_POST['planend']);
    

    if (!empty($planname) && !empty($planLength) && !empty($fees) && !empty($planend)) {
        $stmt = $conn->prepare("UPDATE plans SET planname = ?, planLength = ?, fees = ?, planend = ? WHERE plan_id = ?");
        $stmt->bind_param("ssssi", $planname, $planLength, $fees, $planend, $plan_id);
        if ($stmt->execute()) {
            echo "<script>
            alert('Record updated successfully..');
            window.location.href = 'plan-fees.php';
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
    <h2>Edit Plan</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <form method="POST">
    <div class="form-group">
        <label for="name">Plan Name:</label>
        <input type="text" id="name" class="form-control" name="planname" value="<?php echo htmlspecialchars($club['planname']); ?>" required>
    </div>
    <div class="form-group">
        <label for="position">Plan Length:</label>
        <input type="text" id="position" class="form-control" name="planLength" value="<?php echo htmlspecialchars($club['planLength']); ?>" required>
    </div>

    <div class="form-group">
        <label for="goal">Fees:</label>
        <textarea id="goal" name="fees" class="form-control" required><?php echo htmlspecialchars($club['fees']); ?></textarea>
    </div>

    
    <div class="form-group">
        <label for="goal">Plan End:</label>
        <textarea id="goal" name="planend" class="form-control" required><?php echo htmlspecialchars($club['planend']); ?></textarea>
    </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
