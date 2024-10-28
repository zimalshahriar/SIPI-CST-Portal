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

// Fetch user details from the database
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If the user does not exist, redirect
if (!$user) {
    header('Location: manage_user.php');
    exit;
}

// Fetch available sessions from the database (for student session dropdown)
$sessions = [];
$query = $conn->prepare("SELECT session FROM sessions");
$query->execute();
$resultSessions = $query->get_result();
while ($row = $resultSessions->fetch_assoc()) {
    $sessions[] = $row['session'];
}

// Handle form submission to update user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_type = $user['user_type'];

    // Update student-specific fields
    if ($user_type === 'student') {
        $session = $_POST['session'];
        $semester = $_POST['semester'];
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, session = ?, semester = ? WHERE id = ?");
        $stmt->bind_param('ssssi', $name, $email, $session, $semester, $user_id);
    
    // Update teacher-specific fields
    } elseif ($user_type === 'teacher') {
        $role = $_POST['role'];
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param('sssi', $name, $email, $role, $user_id);
    
    // Update admin fields (only name and email)
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param('ssi', $name, $email, $user_id);
    }

    if ($stmt->execute()) {
        echo "User updated successfully!";
        header('Location: manage_user.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit User</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" required>
            </div>

            <!-- Show fields based on user type -->
            <?php if ($user['user_type'] === 'student'): ?>
                <div class="mb-3">
                    <label for="session" class="form-label">Session</label>
                    <select class="form-select" id="session" name="session" required>
                        <?php foreach ($sessions as $session): ?>
                            <option value="<?= $session ?>" <?= $session == $user['session'] ? 'selected' : '' ?>>
                                <?= $session ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" class="form-control" id="semester" name="semester" value="<?= $user['semester']; ?>" min="1" max="8">
                </div>
            <?php elseif ($user['user_type'] === 'teacher'): ?>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="CI" <?= $user['role'] == 'CI' ? 'selected' : '' ?>>Chief Instructor</option>
                        <option value="Instructor" <?= $user['role'] == 'Instructor' ? 'selected' : '' ?>>Instructor</option>
                        <option value="Junior Instructor" <?= $user['role'] == 'Junior Instructor' ? 'selected' : '' ?>>Junior Instructor</option>
                    </select>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
