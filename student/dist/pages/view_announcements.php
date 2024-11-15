<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Ensure the user is a student
if ($_SESSION['user_type'] !== 'student') {
    header('Location: index.php');
    exit;
}

// Get the student semester from session
$studentSemester = $_SESSION['semester']; // Assuming semester is stored in session

// Fetch announcements for the student's semester or "All Semester"
$stmt = $conn->prepare("SELECT * FROM announcements WHERE semester = ? OR semester = 'All Semester' ORDER BY created_at DESC");
$stmt->bind_param("s", $studentSemester);
$stmt->execute();
$result = $stmt->get_result();
?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Announcements - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Announcements</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($announcement = $result->fetch_assoc()): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($announcement['title']); ?></h5>
                    <p class="card-text">
                        <?php if ($announcement['semester'] === 'All Semester' || $announcement['semester'] === $studentSemester): ?>
                            <?php if ($announcement['content']): ?>
                                <p><?= nl2br(htmlspecialchars($announcement['content'])); ?></p>
                            <?php endif; ?>

                            <?php if ($announcement['file_path']): ?>
                                <a href="<?= htmlspecialchars($announcement['file_path']); ?>" class="btn btn-primary" download>Download PDF</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No announcements available for your semester.</p>
    <?php endif; ?>
</div>
</body>
</html>
</main>
<?php require_once 'partials/footer.php'; ?>
