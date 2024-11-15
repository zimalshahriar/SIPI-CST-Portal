<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sipi_cst_portal');

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Get the announcement ID from the URL query string
$announcementId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Redirect if the ID is invalid
if ($announcementId <= 0) {
    header('Location: manage_announcements.php');
    exit;
}

// Check if the announcement exists
$stmt = $conn->prepare("SELECT * FROM announcements WHERE id = ?");
$stmt->bind_param("i", $announcementId);
$stmt->execute();
$result = $stmt->get_result();
$announcement = $result->fetch_assoc();

if (!$announcement) {
    // If the announcement doesn't exist, redirect
    header('Location: manage_announcements.php');
    exit;
}

// Prepare and execute the delete statement
$stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
$stmt->bind_param("i", $announcementId);
if ($stmt->execute()) {
    // Set a session message for success
    $_SESSION['message'] = "Announcement deleted successfully!";
} else {
    // Set a session message for failure
    $_SESSION['error'] = "Error deleting the announcement.";
}

// Redirect back to the announcements management page
header('Location: manage_announcements.php');
exit;
?>
