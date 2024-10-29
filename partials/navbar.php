<?php
include '../db/database.php'; // Include your database connection file

session_start();

// Ensure user session data is available for displaying info
$user_photo = $_SESSION['photo'] ?? 'default_user.jpg';
$user_name = $_SESSION['name'] ?? 'User';
$user_email = $_SESSION['email'] ?? 'user@example.com';
$user_type = $_SESSION['user_type'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        /* Navbar Styles */
        .navbar {
            background-color: #0056b3 ; /* Blue color */
            color: #fff;
            padding: 10px 0;
        }

        .navbar-brand img {
            height: 40px;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-weight: 500;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            background-color: #007bff; /* Darker blue on hover */
        }

        .navbar-nav .nav-link.active {
            background-color: #0062cc; /* Even darker blue for active link */
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-info p {
            margin: 0;
            color: #fff;
            font-weight: 500;
        }

        .user-info .text {
            font-weight: normal;
        }

        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .navbar-nav {
                text-align: center;
            }

            .user-info {
                justify-content: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../image/sipi.jpg" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcements.php">Announcements</a></li>
                    <li class="nav-item"><a class="nav-link" href="grade_report.php">Result</a></li>
                    <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>
                    <li class="nav-item"><a class="nav-link" href="pay_tuition.php">Tuition Fees</a></li>
                    <li class="nav-item"><a class="nav-link" href="curriculum.php">Subjects</a></li>
                </ul>
            </div>
            <div class="user-info">
                <a href="student_profile.php">
                    <img src="../uploads/logo.jpg?= $user_photo; ?>" alt="User Photo">
                </a>
                <div>
                    <p><strong><?= $user_name; ?></strong></p>
                    <p class="text"><?= $user_email; ?></p>
                    <p class="text"><?= ucfirst($user_type); ?></p>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
