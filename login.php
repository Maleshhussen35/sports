<?php
// Include database connection file
include_once("includes/connection.php");
session_start();

$error_message = $success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("SELECT staff_id, name, password FROM staff WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($staff_id, $name, $stored_password);
            $stmt->fetch();

            // Decode the stored Base64 password and compare
            if (base64_encode(base64_decode($stored_password, true)) === $stored_password) {
                // Check if the provided password matches the stored one
                if (base64_encode($password) === $stored_password) {
                    // Start session and store user information
                    $_SESSION['staff_id'] = $staff_id;
                    $_SESSION['name'] = $name;
                    $success_message = "Login successful. Welcome, " . $name;
                    header("Location: dashboard.php"); // Redirect to dashboard or desired page
                    exit();
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "Invalid stored password format.";
            }
        } else {
            $error_message = "No account found with that email.";
        }

        $stmt->close();
    } else {
        $error_message = "Please fill in both fields.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Sports Club - Login</title>
    <style>
        body {
            background-image: url('../images/sp-1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4" style="width: 100%; max-width: 400px;">
        <h2 class="mt-5">Staff Login</h2>
        <?php
        if (!empty($error_message)) {
            echo '<div class="alert alert-danger">' . $error_message . '</div>';
        }
        if (!empty($success_message)) {
            echo '<div class="alert alert-success">' . $success_message . '</div>';
        }
        ?>
            <!-- <h3 class="text-center mb-4">Staff Login</h3> -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-success btn-block">Login</button>
            <p class="text-center mt-3"><a href="../index.php">Back Home</a></p>
        </form>
        </div>
    </div>
</body>
</html>
