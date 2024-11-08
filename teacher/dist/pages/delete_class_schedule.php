<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sipi_cst_portal');

// Check if the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Check if the ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM class_schedule WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: class_schedule_management.php?message=Schedule deleted successfully.');
    } else {
        header('Location: class_schedule_management.php?message=Error deleting schedule: ' . $stmt->error);
    }

    $stmt->close();
} else {
    header('Location: class_schedule_management.php?message=No schedule ID provided.');
}
?>
