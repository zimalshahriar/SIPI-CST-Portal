<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['user_type'] == 'teacher') {
    // Show teacher-specific content
    echo "<h1>Welcome, Teacher!</h1>";
    echo "<a href='manage-routines.php'>Manage Routines</a>";
    echo "<a href='publish-notices.php'>Publish Notices</a>";
    // Other teacher-specific links
} elseif ($_SESSION['user_type'] == 'student') {
    // Show student-specific content
    echo "<h1>Welcome, Student!</h1>";
    echo "<a href='view-results.php'>View Results</a>";
    echo "<a href='view-class-routines.php'>View Class Routines</a>";
    // Other student-specific links
} else {
    // Handle unknown user type
    echo "Invalid user type!";
}
?>
