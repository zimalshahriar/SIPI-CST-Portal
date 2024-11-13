<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Ensure only logged-in users can access
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-top: 10px;
            color: #2c3e50;
        }

        .container {
            max-width: 1280px;
            padding: 25px;
        }

        .grid-container {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .notice-card {
            background-color: white;
            border-radius: 2px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .notice-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.2);
        }

        .notice-title {
            font-size: 1.5rem;
            font-weight: 500;
            color: #2980b9;
            margin-bottom: 15px;
        }

        .notice-description {
            font-size: 1rem;
            color: #34495e;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .notice-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notice-footer .date {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .notice-footer .btn {
            background-color: #3498db;
            padding: 8px 20px;
            color: white;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .notice-footer .btn:hover {
            background-color: #2980b9;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            h2 {
                font-size: 2.2rem;
            }

            .notice-title {
                font-size: 1.4rem;
            }

            .notice-description {
                font-size: 0.95rem;
            }

            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 2rem;
            }

            .notice-title {
                font-size: 1.3rem;
            }

            .notice-description {
                font-size: 0.9rem;
            }

            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }

            .notice-footer .btn {
                padding: 6px 15px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            h2 {
                font-size: 1.6rem;
            }

            .notice-title {
                font-size: 1.2rem;
            }

            .notice-description {
                font-size: 0.85rem;
            }

            .grid-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .notice-footer .btn {
                padding: 5px 12px;
                font-size: 0.85rem;
            }
        }

    </style>
</head>

<body>

    <div class="container">
        <h2>📢 Latest Notices</h2>

        <?php if ($notices->num_rows > 0): ?>
            <div class="grid-container">
                <?php while ($notice = $notices->fetch_assoc()): ?>
                    <div class="notice-card">
                        <h5 class="notice-title"><?php echo htmlspecialchars($notice['title']); ?></h5>
                        <p class="notice-description"><?php echo nl2br(htmlspecialchars($notice['content'])); ?></p>
                        <div class="notice-footer">
                            <span class="date">Posted on: <?php echo htmlspecialchars($notice['created_at']); ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                No notices available at the moment.
            </div>
        <?php endif; ?>
    </div>

</body>

</html>


</html>
<?php require_once 'partials/footer.php' ?>


