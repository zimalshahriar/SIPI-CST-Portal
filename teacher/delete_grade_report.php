<?php
session_start();
include '../db/database.php';

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Check if the grade report ID is provided
if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$report_id = $_GET['id'];

// Retrieve the grade report to confirm its existence
$reportQuery = $conn->prepare("SELECT * FROM grade_reports WHERE id = ?");
$reportQuery->bind_param("i", $report_id);
$reportQuery->execute();
$gradeReport = $reportQuery->get_result()->fetch_assoc();

if (!$gradeReport) {
    echo "Grade report not found.";
    exit;
}

// Handle deletion after confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $deleteQuery = $conn->prepare("DELETE FROM grade_reports WHERE id = ?");
    $deleteQuery->bind_param("i", $report_id);

    if ($deleteQuery->execute()) {
        echo "Grade report deleted successfully!";
        header("Location: manage_grade_report.php");
        exit;
    } else {
        echo "Error deleting grade report.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Grade Report - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Delete Grade Report</h2>
    
    <!-- Confirmation message -->
    <p>Are you sure you want to delete this grade report for <strong><?= htmlspecialchars($gradeReport['student_name']); ?></strong>?</p>

    <!-- Deletion confirmation form -->
    <form method="POST">
        <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete</button>
        <a href="manage_grade_report.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
