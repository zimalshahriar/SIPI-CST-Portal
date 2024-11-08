<?php
session_start();


// Check if user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Check if 'id' parameter is passed
if (isset($_GET['id'])) {
    $subject_id = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
    $stmt->bind_param('i', $subject_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to subject management page
header('Location: subject_management.php');
exit;
?>
