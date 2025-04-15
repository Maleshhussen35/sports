<?php
include_once("includes/connection.php");

// Initialize message variables
$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mark_present']) || isset($_POST['mark_absent'])) {
        $member_id = intval($_POST['member_id']);
        $date = date('Y-m-d');
        $status = isset($_POST['mark_present']) ? 'Present' : 'Absent';

        // Check if attendance already marked
        $stmt = $conn->prepare("SELECT * FROM attendance WHERE member_id = ? AND attendance_date = ?");
        $stmt->bind_param("is", $member_id, $date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Insert attendance record
            $stmt = $conn->prepare("INSERT INTO attendance (member_id, attendance_date, status) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $member_id, $date, $status);
            if ($stmt->execute()) {
                $success_message = "Attendance marked successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        } else {
            $error_message = "Attendance already marked for today!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Attendance</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include_once("includes/topbar.php"); ?>
<div class="container mt-4">
    <?php
    if (!empty($success_message)) {
        echo "<div class='alert alert-success'>$success_message</div>";
    }
    if (!empty($error_message)) {
        echo "<div class='alert alert-danger'>$error_message</div>";
    }
    ?>

    <h3>Mark Attendance</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Training Time</th>
                <th>Today's Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $member_id = $_REQUEST['member_id'];
        $cnt = 1;
        $query = "SELECT * FROM members WHERE member_id='$member_id'";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></td>
                <td><?php echo htmlspecialchars($row['training_time']); ?></td>
                <td><?php echo date('Y-m-d'); ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="member_id" value="<?php echo $row['member_id']; ?>">
                        <button type="submit" name="mark_present" class="btn btn-success">Mark as Present</button>
                    </form>
                    <br>
                    <form method="post" action="">
                        <input type="hidden" name="member_id" value="<?php echo $row['member_id']; ?>">
                        <button type="submit" name="mark_absent" class="btn btn-warning">Mark as Absent</button>
                    </form>
                </td>
            </tr>
            <?php
            $cnt++;
        }
        ?>
        </tbody>
    </table>
    <a href="memberAttendance.php">Go back</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
