<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Sports Club | Home Page</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Sports Club Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
           
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Welcome to the  Club Management System</h2>
        <p>Select an option from the menu to proceed.</p>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body" style="background:blue;">
                        <h5 class="card-title">Staff Login</h5>
                        <p class="card-text">Staff Portal Panel.</p>
                        <a href="staff/login.php" class="btn btn-light">Login</a>
                    </div>
                </div>
            </div>
<!-- ############################################################################################ -->
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Member Login</h5>
                        <p class="card-text">Mmeber Portal Panel</p>
                        <a href="member/login.php" class="btn btn-light">Login</a>
                    </div>
                </div>
            </div>
<!-- ############################################################################################### -->
<div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Coach Login</h5>
                        <p class="card-text">Coach Portal Panel</p>
                        <a href="coach/login.php" class="btn btn-light">Login</a>
                    </div>
                </div>
            </div>
<!-- ############################################################################################### -->
<div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Admin Login</h5>
                        <p class="card-text">Admin Portal Panel</p>
                        <a href="admin/login.php" class="btn btn-light">Login</a>
                    </div>
                </div>
            </div>
<!-- ############################################################################################### -->
        </div>
    </div>
 <!-- Footer -->
 <footer class="bg-warning text-white text-center py-3 mt-4">
    <p>&copy; 2025 Sports Club Management System. All Rights Reserved.</p>
  </footer>
</body>
</html>
