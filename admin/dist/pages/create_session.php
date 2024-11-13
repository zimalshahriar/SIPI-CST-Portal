<?php
session_start();
require_once 'partials/header.php' ?>
<?php require_once 'partials/navbar.php' ?>
<?php require_once 'partials/sidebar.php'?>
  <main class="app-main">
  <?php
// Check if the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    echo "<script>alert('You do not have permission to access this page.'); window.location.href = 'index.php';</script>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session = $_POST['session'];

    // Insert session into the database
    $query = $conn->prepare("INSERT INTO sessions (session) VALUES (?)");
    $query->bind_param('s', $session);

    if ($query->execute()) {
        $success_message = "Session created successfully!";
    } else {
        $error_message = "Error creating session: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Session - SIPI CST Portal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 100%;
            background-color: #fff;
            border-radius: 0px;
            padding: 20px 30px;
            margin-top: 0px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            animation: fadeIn 0.7s ease;
        }

        h2 {
            color: #333;
            font-weight: 700;
            text-align: center;
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr;
        }

        .form-label {
            color: #555;
            font-weight: 500;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #1d4e89;
            border-color: #1d4e89;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            width: 30%;
        }
        .btn-primary:hover{
            background-color: #1d4e89;
        }

        /* Responsive Styles */
        @media (min-width: 768px) {
            .container {
                grid-template-columns: 1fr 1fr;
            }

            .form-group {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 15px 20px;
            }
            h2 {
                font-size: 1.5rem;
            }
            .btn-primary {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create New Academic Session</h2>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="post" class="form-group">
            <div class="mb-3">
                <label for="session" class="form-label">Session (e.g., 2023-24)</label>
                <input type="text" class="form-control" id="session" name="session" placeholder="Enter session" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Session</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</main>
<?php require_once 'partials/footer.php' ?>
