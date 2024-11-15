<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Fetch announcements published by this teacher
$announcements = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");

?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #f8f9fa, #ffffff);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1300px;
            padding: 25px;
            background: linear-gradient(to left, #f6fcfb, #f9fcff );
        }

        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .announcement-grid {
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .announcement-card {
            flex: 1 1 calc(33.33% - 1rem);
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .announcement-header {
            font-size: 1.25rem;
            font-weight: bold;
            color: #0d457c ;
            margin-bottom: 0.5rem;
        }

        .announcement-details {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 1rem;
        }

        .announcement-actions {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-edit {
            background: #007bff;
            color: #fff;
            border: none;
        }

        .btn-edit:hover {
            background: #1180ec  ;
            transform: scale(1.05);
        }

        .btn-delete {
            background: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-delete:hover {
            background: #bd2130;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .announcement-card {
                flex: 1 1 calc(100% - 1rem);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Announcements</h2>

    <!-- Success Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Announcements Grid -->
    <div class="announcement-grid">
        <?php while ($announcement = $announcements->fetch_assoc()): ?>
            <div class="announcement-card">
                <div class="announcement-header">
                    <?= htmlspecialchars($announcement['title']); ?>
                </div>
                <div class="announcement-details">
                    <p><strong>Semester:</strong> <?= htmlspecialchars($announcement['semester']); ?></p>
                    <p><strong>Type:</strong> <?= isset($announcement['file_path']) ? 'PDF' : 'Text'; ?></p>
                    <p><strong>Created At:</strong> <?= htmlspecialchars($announcement['created_at']); ?></p>
                </div>
                <div class="announcement-actions">
                    <a href="edit_announcement.php?id=<?= $announcement['id']; ?>" class="btn btn-edit">Edit</a>
                    <a href="delete_announcement.php?id=<?= $announcement['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this announcement?');">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</main>
<?php
require_once 'partials/footer.php';
?>
