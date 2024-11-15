<?php
session_start();
require_once '../../../db/database.php';
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Initialize variables to prevent undefined variable warnings
$error = null;
$success = null;

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to get the current hashed password from the database
$sql = "SELECT user_id, password FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error in SQL statement preparation: " . $conn->error);
}
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("No user found with the given user_id in the session.");
}

$row = $result->fetch_assoc();
$user_identifier = $row['user_id'];
$hashed_password = $row['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate current password
    if (!password_verify($current_password, $hashed_password)) {
        $error = "Current password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New password and confirmation do not match.";
    } else {
        // Hash the new password and update in the database
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            die("Error in SQL statement preparation: " . $conn->error);
        }
        $update_stmt->bind_param("ss", $new_hashed_password, $user_id);
        if ($update_stmt->execute()) {
            $success = "Password updated successfully.";
        } else {
            $error = "Failed to update the password.";
        }
        $update_stmt->close();
    }
}

$stmt->close();
$conn->close();
?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Arial", sans-serif;
            background: linear-gradient(to right, #e9effd, #f9fcff);
            margin: 0;
            padding: 0;
            color: #444;
        }

        .container {
            max-width: 1500px;
            padding: 96px;
            background: linear-gradient(to right, #f6fcfb, #f9fcff );
            border-radius: 2px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-rows: auto;
            gap: 30px;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #00376b;
            margin-bottom: 10px;
        }

        .text-muted {
            text-align: center;
            font-size: 1rem;
            color: #777;
        }

        .form-container {
            
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
        }

        .form-control {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            background: #f8f9fa;
            color: #444;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .btn-primary {
            grid-column: span 2;
            padding: 14px;
            font-size: 1.2rem;
            font-weight: bold;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border: none;
            border-radius: 8px;
            color: white;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(90deg, #0056b3, #003f7d);
        }

        .alert {
            padding: 10px;
            border-radius: 8px;
            font-size: 1rem;
            text-align: center;
        }

        /* For mobile devices */
        @media (max-width: 768px) {
            .form-container {
                grid-template-columns: 1fr;
            }

            .btn-primary {
                grid-column: span 1;
            }
        }

        /* Adding subtle animations */
        .form-container input, 
        .form-container label {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Settings</h2>
    <p class="text-muted">Change your account password below.</p>

    <!-- Alerts -->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Form -->
    <form action="settings.php" method="POST" class="form-container">
        <div class="form-group">
            <label for="user_identifier">User ID</label>
            <input type="text" id="user_identifier" class="form-control" value="<?= htmlspecialchars($user_identifier) ?>" readonly>
        </div>

        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn-primary">Update Password</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</main>
<?php require_once 'partials/footer.php' ?>
