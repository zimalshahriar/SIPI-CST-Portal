<?php
session_start();
include '../db/database.php';

// Check if the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Fetch existing sessions from the database
$sessions = [];
$query = $conn->prepare("SELECT session FROM sessions");
$query->execute();
$result = $query->get_result();
while ($row = $result->fetch_assoc()) {
    $sessions[] = $row['session'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - SIPI CST Portal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Add New User</h2>
        <form action="process_add_user.php" method="post" enctype="multipart/form-data">
            <!-- Select User Type -->
            <div class="mb-3">
                <label for="user_type" class="form-label">Select User Type</label>
                <select id="user_type" name="user_type" class="form-select" required>
                    <option value="" selected disabled>Select user type</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Common Fields -->
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID</label>
                <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Enter user ID" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Initial Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter initial password" required>
            </div>

            <!-- Session Selection for Students -->
            <div id="student-fields" style="display: none;">
                <div class="mb-3">
                    <label for="session" class="form-label">Select Session</label>
                    <select class="form-select" id="session" name="session" required>
                        <option value="" selected disabled>Select session</option>
                        <?php foreach ($sessions as $session): ?>
                            <option value="<?php echo $session; ?>"><?php echo $session; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" class="form-control" id="semester" name="semester" min="1" max="8" placeholder="Enter semester" required>
                </div>
            </div>

            <!-- Additional Fields for Teachers -->
            <div id="teacher-fields" style="display: none;">
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="CI">Chief Instructor</option>
                        <option value="Instructor">Instructor</option>
                        <option value="Junior Instructor">Junior Instructor</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Upload Photo</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>

            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../js/script.js"></script>
</body>

</html>