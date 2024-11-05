<?php
include '../db/database.php';
include '../partials/navbar.php';
include '../partials/sidebar.php';

// Ensure only logged-in users can access
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the logged-in user’s semester
$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT semester FROM users WHERE user_id = ?");
$query->bind_param("s", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$user_semester = $user['semester'];

// Fetch notices for the student's semester or "All Semester"
$stmt = $conn->prepare("
    SELECT * FROM notices 
    WHERE semester = ? OR semester = 'All Semester' 
    ORDER BY created_at DESC
");
$stmt->bind_param("s", $user_semester);
$stmt->execute();
$notices = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            color: #2c3e50;
        }

        h2 {
            margin-bottom: 30px;
            color: #2980b9;
            animation: slideIn 1.5s;
            font-weight: 600;
            font-size: 2rem;
        }

        .list-group-item {
            background: linear-gradient(145deg, #ffffff, #ecf0f1);
            margin-bottom: 20px;
            border: none;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .list-group-item:hover {
            transform: scale(1.05);
            box-shadow: 4px 8px 12px rgba(0, 0, 0, 0.2);
        }

        .notice-icon {
            font-size: 1.5rem;
            margin-right: 15px;
            color: #3498db;
        }

        .notice-title {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.25rem;
        }

        .notice-content {
            margin: 10px 0;
            color: #5d6d7e;
        }

        .text-muted {
            font-size: 0.85rem;
            color: #95a5a6;
        }

        .container {
            max-width: 700px;
            padding: 55px;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 1.7rem;
            }

            .notice-title {
                font-size: 1.1rem;
            }

            .list-group-item {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            h2 {
                font-size: 1.5rem;
            }

            .notice-icon {
                font-size: 1.2rem;
            }

            .notice-title {
                font-size: 1rem;
            }

            .list-group-item {
                padding: 10px;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">📢 Latest Announcements</h2>

        <?php if ($notices->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($notice = $notices->fetch_assoc()): ?>
                    <li class="list-group-item d-flex align-items-start">
                        <span class="notice-icon">📄</span>
                        <div>
                            <h5 class="notice-title">
                                <?php echo htmlspecialchars($notice['title']); ?>
                            </h5>
                            <p class="notice-content">
                                <?php echo nl2br(htmlspecialchars($notice['content'])); ?>
                            </p>
                            <small class="text-muted">
                                Posted on: <?php echo htmlspecialchars($notice['created_at']); ?>
                            </small>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                No announcements available at the moment.
            </div>
        <?php endif; ?>
    </div>
</body>

</html>


