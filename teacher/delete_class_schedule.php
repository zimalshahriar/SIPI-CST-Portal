<?php
session_start();
include '../db/database.php';

// Check if the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Check if the ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM class_schedule WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Success, redirect back to the management page
        header('Location: class_schedule_management.php');
        exit;
    } else {
        // Handle error
        echo "Error deleting schedule: " . $stmt->error;
    }

    $stmt->close();
} else {
    // If no ID is set, redirect back to the management page
    header('Location: class_schedule_management.php');
    exit;
}
?>
