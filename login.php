<?php
session_start();
include 'db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $query->bind_param('s', $user_id);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];  // Assuming $user['email'] is fetched from the database
        $_SESSION['photo'] = $user['photo'];  // Assuming this is for the profile photo

        // Redirect to the appropriate dashboard
        if ($user['user_type'] === 'student') {
            header('Location: student/index.php');
        } elseif ($user['user_type'] === 'teacher') {
            header('Location: teacher/index.php');
        } else {
            header('Location: admin/index.php');
        }
    } else {
        // Invalid login credentials
        $error = "Invalid user ID or password";
        echo "<script>alert('$error');</script>";
    }
}
?>
