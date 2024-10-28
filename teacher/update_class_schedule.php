<?php
session_start();
include '../db/database.php';

// Check if the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $subject_id = $_POST['subject_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $semester = $_POST['semester'];

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE class_schedule SET subject_id = ?, day = ?, start_time = ?, end_time = ?, semester = ? WHERE id = ?");
    $stmt->bind_param('issssi', $subject_id, $day, $start_time, $end_time, $semester, $id);

    if ($stmt->execute()) {
        // Success, redirect back to the management page
        header('Location: class_schedule_management.php');
        exit;
    } else {
        // Handle error
        echo "Error updating schedule: " . $stmt->error;
    }

    $stmt->close();
}
?>
