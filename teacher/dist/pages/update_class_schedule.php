<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sipi_cst_portal');

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
        header('Location: class_schedule_management.php?message=Schedule updated successfully.');
        exit;
    } else {
        // Handle error
        echo "Error updating schedule: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch the current class schedule record based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $schedule_result = $conn->query("SELECT * FROM class_schedule WHERE id = $id");
    $current_schedule = $schedule_result->fetch_assoc();
} else {
    header('Location: class_schedule_management.php?error=No schedule found.');
    exit;
}

// Fetch existing subjects for the dropdown
$subjects = $conn->query("SELECT * FROM subjects");
?>
