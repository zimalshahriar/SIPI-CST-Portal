<?php
require_once './partials/header.php';
ob_start(); // Start output buffering
include '../db/database.php';
require_once './partials/navbar.php';
require_once './partials/sidebar.php';

// Check if the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Fetch all teachers for the dropdown
$teachers = $conn->query("SELECT name FROM users WHERE user_type = 'teacher'");

// Handle form submission to add class schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_id = $_POST['subject_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $teacher_name = $_POST['teacher_name'];
    $semester = $_POST['semester'];

    $stmt = $conn->prepare("INSERT INTO class_schedule (subject_id, day, start_time, end_time, teacher_name, semester) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssss', $subject_id, $day, $start_time, $end_time, $teacher_name, $semester);
    $stmt->execute();
    $stmt->close();
    // header('Location: class_schedule_management.php');
}
ob_end_flush(); // End output buffering and flush output

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <title>Add Class Schedule - SIPI CST Portal</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Add Class Schedule</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select" id="subject_id" name="subject_id" required>
                    <option value="">Select Subject</option>
                    <?php
                    $subjects = $conn->query("SELECT id, subject_name FROM subjects");
                    while ($row = $subjects->fetch_assoc()): ?>
                        <option value="<?= $row['id']; ?>"><?= $row['subject_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="day" class="form-label">Day</label>
                <select class="form-select" id="day" name="day" required>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
            <div class="mb-3">
                <label for="teacher_name" class="form-label">Teacher Name</label>
                <select class="form-select" id="teacher_name" name="teacher_name" required>
                    <option value="">Select Teacher</option>
                    <?php while ($row = $teachers->fetch_assoc()): ?>
                        <option value="<?= $row['name']; ?>"><?= $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select class="form-select" id="semester" name="semester" required>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                    <option value="3rd">3rd</option>
                    <option value="4th">4th</option>
                    <option value="5th">5th</option>
                    <option value="6th">6th</option>
                    <option value="7th">7th</option>
                    <option value="8th">8th</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Schedule</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once './partials/footer.php'; ?>
