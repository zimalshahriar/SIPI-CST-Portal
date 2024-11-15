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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - SIPI CST Portal</title>
    <style>
        /* Base Styles */
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f8fc;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1300px;
            padding: 30px;
            height: 95vh;
            background: linear-gradient(to left, #f6fcfb, #f9fcff );
        }

        h2 {
            font-size: 2rem;
            color: #004085;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        /* Notice Styles */
        .announcement-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .announcement {
            display: flex;
            flex-direction: column;
            background: #ffffff;
            border-left: 5px solid #007bff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .announcement:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .announcement-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .announcement-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #004085;
        }

        .announcement-date {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .announcement-content {
            font-size: 1rem;
            line-height: 1.6;
            margin-top: 10px;
            color: #555;
        }

        .announcement-footer {
            margin-top: 15px;
            text-align: right;
        }

        .btn {
            padding: 8px 15px;
            font-size: 0.9rem;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .announcement-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .announcement-title {
                margin-bottom: 5px;
            }

            .announcement-footer {
                text-align: left;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Announcements</h2>
    <div class="announcement-list">
        <!-- Example Announcements (Replace PHP code with your dynamic content) -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($announcement = $result->fetch_assoc()): ?>
                <?php if ($announcement['semester'] === 'All Semester' || $announcement['semester'] === $studentSemester): ?>
                    <div class="announcement">
                        <div class="announcement-header">
                            <div class="announcement-title"><?= htmlspecialchars($announcement['title']); ?></div>
                            <div class="announcement-date">
                                <?php 
                                // Ensure the 'date' field exists in your database table
                                echo htmlspecialchars(date("F j, Y", strtotime($announcement['date'] ?? 'now')));
                                ?>
                            </div>
                        </div>
                        <div class="announcement-content">
                            <?= nl2br(htmlspecialchars($announcement['content'] ?? '')); ?>
                        </div>
                        <?php if ($announcement['file_path']): ?>
                            <div class="announcement-footer">
                                <a href="<?= htmlspecialchars($announcement['file_path']); ?>" class="btn" download>Download PDF</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No announcements available for your semester.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

</main>
<?php require_once 'partials/footer.php'; ?>
