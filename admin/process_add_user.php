<?php
session_start();
include '../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_type = $_POST['user_type'];
    $user_id = $_POST['user_id']; // Get user_id from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hash
    $photo = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    
    // Check if the 'uploads' folder exists, if not, create it
    $uploads_dir = '../uploads';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    // Move the uploaded photo to the 'uploads' folder
    move_uploaded_file($photo_tmp, $uploads_dir . "/" . $photo);
    
    // Check if user_id already exists
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $checkStmt->bind_param('s', $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        echo "Error: User ID already exists.";
    } else {
        if ($user_type === 'student') {
            // Student-specific fields
            $session = $_POST['session'];
            $semester = $_POST['semester'];
            $stmt = $conn->prepare("INSERT INTO users (user_id, name, email, password, user_type, session, semester, photo) VALUES (?, ?, ?, ?, 'student', ?, ?, ?)");
            $stmt->bind_param('sssssis', $user_id, $name, $email, $password, $session, $semester, $photo);
            
        } elseif ($user_type === 'teacher') {
            // Teacher-specific fields
            $role = $_POST['role'];
            $stmt = $conn->prepare("INSERT INTO users (user_id, name, email, password, user_type, role, photo) VALUES (?, ?, ?, ?, 'teacher', ?, ?)");
            $stmt->bind_param('ssssss', $user_id, $name, $email, $password, $role, $photo);
            
        } elseif ($user_type === 'admin') {
            // Admin-specific fields
            $stmt = $conn->prepare("INSERT INTO users (user_id, name, email, password, user_type, photo) VALUES (?, ?, ?, ?, 'admin', ?)");
            $stmt->bind_param('sssss', $user_id, $name, $email, $password, $photo);
        }

        if ($stmt->execute()) {
            echo "User added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>
