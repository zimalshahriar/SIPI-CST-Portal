<?php
session_start();

// Ensure user session data is available for displaying info
$user_photo = $_SESSION['photo'] ?? 'default_user.jpg'; // Default photo if none provided
$user_name = $_SESSION['name'] ?? 'User';
$user_email = $_SESSION['email'] ?? 'user@example.com';
$user_type = $_SESSION['user_type'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Header</title>
</head>
<body>

<!-- Header Section -->
<header class="header">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left: SIPI Logo -->
            <div class="col-md-3 logo">
                <a href="index.php">
                    <img src="path_to_your_logo/sipi_logo.png" alt="SIPI Logo">
                </a>
            </div>

            <!-- Middle: Institute Name -->
            <div class="col-md-6 text-center">
                <h2>Shyamoli Ideal Polytechnic Institute</h2>
            </div>

            <!-- Right: User Info -->
            <div class="col-md-3 user-info text-end">
                <img src="uploads/<?= $user_photo; ?>" alt="User Photo">
                <div>
                    <p class="mb-0"><strong><?= $user_name; ?></strong></p>
                    <p class="mb-0"><?= $user_email; ?></p>
                    <p class="mb-0 text-muted"><?= ucfirst($user_type); ?></p>
                </div>
            </div>
        </div>
    </div>
</header>

</body>
</html>
