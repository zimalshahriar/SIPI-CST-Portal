<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Check if the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
  header('Location: index.php');
  exit;
}

// Fetch subjects handled by the teacher
$subjects = $conn->query("SELECT * FROM subjects ORDER BY semester");

// Fetch attendance report if form is submitted
$attendanceRecords = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $date = $_POST['date'];
  $subject_id = $_POST['subject_id'];

  // Fetch attendance records for the selected date and subject
  $stmt = $conn->prepare("SELECT a.date, s.subject_name, u.id AS student_id, u.name AS student_name, a.status
                          FROM attendance a
                          JOIN users u ON a.student_id = u.id
                          JOIN subjects s ON a.subject_id = s.id
                          WHERE a.date = ? AND a.subject_id = ?");
  $stmt->bind_param('si', $date, $subject_id);
  $stmt->execute();
  $attendanceRecords = $stmt->get_result();
}
?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Attendance Report - SIPI CST Portal</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2>Attendance Report</h2>

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
      <button type="submit" class="btn btn-primary">View Report</button>
  </form>

  <?php if ($attendanceRecords && $attendanceRecords->num_rows > 0): ?>
      <h3 class="mt-4">Attendance Records for <?= htmlspecialchars($_POST['date']); ?></h3>
      <table class="table table-bordered mt-3">
          <thead>
              <tr>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Subject</th>
                  <th>Status</th>
              </tr>
          </thead>
          <tbody>
              <?php while ($record = $attendanceRecords->fetch_assoc()): ?>
                  <tr>
                      <td><?= $record['student_id']; ?></td>
                      <td><?= $record['student_name']; ?></td>
                      <td><?= $record['subject_name']; ?></td>
                      <td><?= $record['status']; ?></td>
                  </tr>
              <?php endwhile; ?>
          </tbody>
      </table>
  <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
      <p class="mt-4">No attendance records found for the selected date and subject.</p>
  <?php endif; ?>
</div>
</body>
</html>
</main>
<?php require_once 'partials/footer.php' ?>
