<?php
session_start();
include '../db/database.php';

// Check if user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Fetch subjects by the teacher's assigned semester
$teacher_id = $_SESSION['user_id'];
$subjects = $conn->query("SELECT * FROM subjects ORDER BY semester");

// Handle adding a new schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_id = $_POST['subject_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $stmt = $conn->prepare("INSERT INTO class_schedule (subject_id, teacher_id, day, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('iisss', $subject_id, $teacher_id, $day, $start_time, $end_time);
    $stmt->execute();
    $stmt->close();
    header('Location: manage_class_schedule.php');
}

// Fetch class schedule for the teacher
$schedule = $conn->query("SELECT class_schedule.*, subjects.subject_name, subjects.semester FROM class_schedule 
    JOIN subjects ON class_schedule.subject_id = subjects.id 
    WHERE class_schedule.teacher_id = $teacher_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Class Schedule - SIPI CST Portal</title>
    <!-- Include Bootstrap CSS -->
</head>
<body>
<div class="container mt-5">
    <h2>Manage Class Schedule</h2>
    <form method="POST">
        <select name="subject_id" required>
            <option value="">Select Subject</option>
            <?php while ($row = $subjects->fetch_assoc()): ?>
                <option value="<?= $row['id']; ?>"><?= $row['subject_name'] . " (" . $row['semester'] . ")"; ?></option>
            <?php endwhile; ?>
        </select>
        <select name="day" required>
            <option value="">Select Day</option>
            <option value="Sunday">Sunday</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Saturday">Saturday</option>
        </select>
        <input type="time" name="start_time" required>
        <input type="time" name="end_time" required>
        <button type="submit">Add Schedule</button>
    </form>

    <table class="table mt-3">
        <thead><tr><th>Subject</th><th>Day</th><th>Time</th><th>Actions</th></tr></thead>
        <tbody>
            <?php while ($row = $schedule->fetch_assoc()): ?>
            <tr>
                <td><?= $row['subject_name'] . " (" . $row['semester'] . ")"; ?></td>
                <td><?= $row['day']; ?></td>
                <td><?= date("H:i", strtotime($row['start_time'])) . " - " . date("H:i", strtotime($row['end_time'])); ?></td>
                <td>
                    <a href="edit_schedule.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete_schedule.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
