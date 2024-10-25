<?php
// Start a session
session_start();

// Check if the user is already logged in, redirect to their respective dashboard
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'student') {
        header('Location: student/index.php');
    } elseif ($_SESSION['user_type'] === 'teacher') {
        header('Location: teacher/index.php');
    } else {
        header('Location: admin/index.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SIPI CST Portal</title>
    <!-- Add Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Welcome to SIPI CST Portal</h1>
        <p class="lead">Shyamoli Ideal Polytechnic Institute - Computer Science and Technology Department</p>
        
        <!-- Login Section -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title">Login</h2>
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Enter your ID" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-5">
            <p>&copy; 2024 Shyamoli Ideal Polytechnic Institute - CST Department</p>
        </footer>
    </div>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
