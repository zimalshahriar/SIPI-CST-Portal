<?php
// Include database connection
include 'db/database.php';

// Define admin user details
$user_id = 'admin-1';
$name = 'Shahriar Zim';
$email = 'admin@example.com';
$password = '1245678'; // Raw password for admin
$user_type = 'admin';

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL statement to insert admin user
$query = $conn->prepare("INSERT INTO users (user_id, name, email, password, user_type) VALUES (?, ?, ?, ?, ?)");
$query->bind_param('sssss', $user_id, $name, $email, $hashed_password, $user_type);

// Execute the query
if ($query->execute()) {
    echo "Admin user added successfully.";
} else {
    echo "Error: " . $query->error;
}

// Close the statement and connection
$query->close();
$conn->close();
?>
