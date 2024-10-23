<?php
session_start();


function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}


function isStudent() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'student';
}


function isTeacher() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'teacher';
}


if (!isLoggedIn()) {
    header("Location: ./partials/login.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            font-size: 1.5rem;
        }
        .login-btn {
            background-color: #007bff;
            color: #fff;
            border-radius: 25px;
            padding: 5px 15px;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SIPI CST Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="fa fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="notice.php">
                            <i class="fa fa-bell"></i> Announcements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="routine.php">
                            <i class="fa fa-calendar"></i> Routine
                        </a>
                    </li>

                    <?php if (isStudent()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="my_profile.php">
                            <i class="fa fa-user"></i> My Profile
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if (isTeacher()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fa fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <?php if (!isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link btn login-btn" href="logout.php">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
