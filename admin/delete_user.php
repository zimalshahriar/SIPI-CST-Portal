<?php
session_start();
include '../db/database.php';

// Check if the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Get user ID from URL
$user_id = $_GET['id'];

// Delete the user from the database
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);

if ($stmt->execute()) {
    header('Location: manage_user.php?message=User+deleted+successfully');
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
