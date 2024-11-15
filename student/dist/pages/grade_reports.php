<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Check if student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'student') {
    header('Location: login.php'); // Redirect to login if not logged in as student
    exit();
}

$student_id = $_SESSION['id'];  // Get the student ID from session
$semester = $_SESSION['semester'];   // Get the student semester from session

// Fetch the grade report for the student in the specific semester
$query = "SELECT gr.*, s.subject_name FROM grade_reports gr
          JOIN subjects s ON gr.subject_id = s.id
          WHERE gr.student_id = ? AND gr.semester = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $student_id, $semester);
$stmt->execute();
$result = $stmt->get_result();
?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background: linear-gradient(to left, #f6fcfb, #f9fcff );
        }
    </style>
</head>
<body>

<div class="si mt-5">
    <h3 class="text-center">Grade Report for Semester <?php echo htmlspecialchars($semester); ?></h3>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-hover table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Subject</th>
                    <th>Attendance</th>
                    <th>Total TC</th>
                    <th>Total PC</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['attendance']); ?>%</td>
                        <td><?php echo htmlspecialchars($row['total_tc']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_pc']); ?></td>
                        <td><?php echo htmlspecialchars($row['remarks']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-warning mt-3">No grade reports found for this semester.</p>
    <?php endif; ?>

    <?php
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>
</div>

<!-- Bootstrap JS (optional) and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
</main>
<?php require_once 'partials/footer.php'; ?>
