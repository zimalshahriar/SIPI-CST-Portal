<?php
session_start();
include '../db/database.php';

// Check if the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Fetch subjects handled by the teacher
$subjects = $conn->query("SELECT * FROM subjects ORDER BY semester");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $subject_id = $_POST['subject_id'];
    $student_ids = $_POST['student_id'];
    $statuses = $_POST['status'];

    // Insert attendance records for each student
    foreach ($student_ids as $index => $student_id) {
        $status = $statuses[$index];
        $stmt = $conn->prepare("INSERT INTO attendance (date, subject_id, student_id, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('siis', $date, $subject_id, $student_id, $status);
        $stmt->execute();
    }

    header('Location: attendance.php?message=Attendance recorded successfully');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance - SIPI CST Portal</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Mark Attendance</h2>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success"><?= $_GET['message']; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="subject_id" class="form-label">Subject</label>
            <select id="subject_id" name="subject_id" class="form-select" required>
                <option value="">Select Subject</option>
                <?php while ($subject = $subjects->fetch_assoc()): ?>
                    <option value="<?= $subject['id']; ?>"><?= $subject['subject_name']; ?> - <?= $subject['semester']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="button" class="btn btn-primary" id="fetchStudents">Fetch Students</button>
        <div id="studentsList" class="mt-3"></div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '#fetchStudents', function () {
    const subjectId = $('#subject_id').val();
    if (subjectId) {
        $.ajax({
            url: 'fetch_students.php',
            method: 'POST',
            data: { subject_id: subjectId },
            success: function (response) {
                $('#studentsList').html(response);
            }
        });
    } else {
        alert('Please select a subject.');
    }
});
</script>
</body>
</html>
