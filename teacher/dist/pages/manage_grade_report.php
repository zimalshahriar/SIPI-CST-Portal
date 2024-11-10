<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';
?>
<main class="app-main">
<?php
// Ensure the user is a teacher
// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
  header('Location: index.php');
  exit;
}

// Define all semesters
$semesters = ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'];

// Initialize variables
$subjects = [];
$gradeReports = [];

// Fetch subjects if semester is selected
if (isset($_POST['semester'])) {
  $semester = $_POST['semester'];
  $subjects = $conn->query("SELECT * FROM subjects WHERE semester = '$semester'");
}

// Fetch grade reports if both semester and subject are selected
if (isset($_POST['subject_id']) && isset($_POST['semester'])) {
  $subject_id = $_POST['subject_id'];
  $semester = $_POST['semester'];

  // Modified query to join grade_reports with users to fetch student names
  $gradeReports = $conn->query("
      SELECT grade_reports.*, users.name AS student_name
      FROM grade_reports
      JOIN users ON grade_reports.student_id = users.id
      WHERE grade_reports.semester = '$semester' AND grade_reports.subject_id = '$subject_id'
  ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Grade Reports - SIPI CST Portal</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2>Manage Grade Reports</h2>

  <!-- Form to select semester and subject -->
  <form method="POST">
      <div class="mb-3">
          <label for="semester" class="form-label">Select Semester</label>
          <select id="semester" name="semester" class="form-select" required>
              <option value="">Select Semester</option>
              <?php foreach ($semesters as $sem): ?>
                  <option value="<?= $sem; ?>" <?= (isset($semester) && $semester === $sem) ? 'selected' : ''; ?>><?= $sem; ?></option>
              <?php endforeach; ?>
          </select>
      </div>

      <?php if (!empty($subjects) && $subjects->num_rows > 0): ?>
          <div class="mb-3">
              <label for="subject_id" class="form-label">Select Subject</label>
              <select id="subject_id" name="subject_id" class="form-select" required>
                  <option value="">Select Subject</option>
                  <?php while ($subject = $subjects->fetch_assoc()): ?>
                      <option value="<?= $subject['id']; ?>"><?= $subject['subject_name']; ?></option>
                  <?php endwhile; ?>
              </select>
          </div>
      <?php endif; ?>

      <button type="submit" class="btn btn-primary">Load Grade Reports</button>
  </form>

  <!-- Grade Report Table -->
  <?php if ($gradeReports && isset($subject_id) && isset($semester)): ?>
      <table class="table table-bordered mt-4">
          <thead>
              <tr>
                  <th>SL</th>
                  <th>Name</th>
                  <th>College ID</th>
                  <th>Attendance</th>
                  <th>Total TC</th>
                  <th>Total PC</th>
                  <th>Remarks</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              <?php $i = 1; ?>
              <?php while ($report = $gradeReports->fetch_assoc()): ?>
                  <tr>
                      <td><?= $i++; ?></td>
                      <td><?= htmlspecialchars($report['student_name']); ?></td> <!-- Displaying student name -->
                      <td><?= htmlspecialchars($report['student_id']); ?></td>
                      <td><?= htmlspecialchars($report['attendance']); ?></td>
                      <td><?= htmlspecialchars($report['total_tc']); ?></td>
                      <td><?= htmlspecialchars($report['total_pc']); ?></td>
                      <td><?= htmlspecialchars($report['remarks']); ?></td>
                      <td>
                          <a href="edit_grade_report.php?id=<?= $report['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                          <a href="delete_grade_report.php?id=<?= $report['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this report?');">Delete</a>
                      </td>
                  </tr>
              <?php endwhile; ?>
          </tbody>
      </table>
  <?php endif; ?>
</div>
</body>
</html>
</main>
<?php require_once './partials/footer.php'; ?>
