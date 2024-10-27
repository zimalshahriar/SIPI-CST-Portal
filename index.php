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
    <title>SIPI CST Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
        }
        .login-section {
            animation: fadeInLeft 1s ease;
        }
        .image-section img {
            width: 100%;
            max-width: 550px;
            border-radius: 5px;
            animation: fadeInRight 1s ease;
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="container text-center mt-5">
        <h1>WELCOME TO SIPI CST PORTAL</h1>
        <h2 class="lead ">Shyamoli Ideal Polytechnic Institute - Computer Science and Technology Department</h2>
        
        <div class="row mt-5 align-items-center">
            <!-- Login Section -->
            <div class="col-md-6 login-section">
                <div class="card shadow-lg bg-light text-dark">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Login</h2>
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Enter your ID" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side Image Section -->
            <div class="col-md-6 image-section d-flex justify-content-center">
                <img src="image/22344038_Team of programmers working on program code with laptops.jpg" alt="CST Department Image" class="shadow-lg">
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-5">
            <p>&copy; 2024 Shyamoli Ideal Polytechnic Institute - CST Department</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

