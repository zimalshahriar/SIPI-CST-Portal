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
    <title>Manage Announcements - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Announcements</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Announcements Table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Title</th>
                <th>Semester</th>
                <th>Type</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($announcement = $announcements->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($announcement['title']); ?></td>
                    <td><?= htmlspecialchars($announcement['semester']); ?></td>
                    <td><?= isset($announcement['file_path']) ? 'PDF' : 'Text'; ?></td>
                    <td><?= htmlspecialchars($announcement['created_at']); ?></td>
                    <td>
                        <a href="edit_announcement.php?id=<?= $announcement['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_announcement.php?id=<?= $announcement['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this announcement?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
</main>
<?php
require_once 'partials/footer.php';
?>
