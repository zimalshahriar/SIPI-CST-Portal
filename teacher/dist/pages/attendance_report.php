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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Report - SIPI CST Portal</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
      /* Global Styles */
      body {
          font-family: 'Roboto', sans-serif;
          background-color: #f4f6f9;
          color: #333;
          background: linear-gradient(to left, #f6fcfb, #f9fcff );
      }

      /* Main Container */
      .container {
          max-width: 900px;
          margin: 2rem auto;
          padding: 2rem;
          background: #ffffff;
          border-radius: 12px;
          box-shadow: 0 8px 10px rgba(0, 0, 0, 0.1);
      }

      h2, h3 {
          font-weight: 600;
          text-align: center;
          color: #495057;
      }

      /* Form Styles */
      .form-label {
          font-weight: 500;
      }

      .form-control, .form-select {
          border-radius: 8px;
          transition: box-shadow 0.2s ease, transform 0.2s ease;
      }

      .form-control:hover, .form-select:hover {
          box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
          transform: scale(1.01);
      }

      /* Buttons */
      .btn-primary {
          background-color: #007bff;
          border: none;
          border-radius: 8px;
          font-weight: 500;
          padding: 10px 20px;
          transition: background-color 0.3s, transform 0.2s;
      }

      .btn-primary:hover {
          background-color: #0056b3;
          transform: scale(1.05);
      }

      /* Table Styles */
      .table-container {
          margin-top: 2rem;
          overflow-x: auto;
      }

      table {
          border-collapse: collapse;
          width: 100%;
          box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
          border-radius: 12px;
      }

      th {
          background-color: #6c63ff;
          color: #fff;
          text-align: center;
          padding: 10px;
          font-weight: 600;
      }

      td {
          text-align: center;
          padding: 10px;
      }

      tr:nth-child(even) {
          background-color: #f8f9fa;
      }

      tr:hover {
          background-color: #e9ecef;
      }

      /* Footer */
      .footer {
          background-color: #007bff;
          color: #fff;
          text-align: center;
          padding: 15px 0;
          margin-top: 50px;
      }

      .footer a {
          color: #e6e6e6;
          text-decoration: none;
      }

      .footer a:hover {
          color: #fff;
      }

      /* No Records Found */
      .no-records {
          margin-top: 2rem;
          text-align: center;
          font-size: 1.1rem;
          color: #888;
      }
  </style>
</head>
<body>

<!-- Main Content -->
<div class="container">
  <h2><i class="fas fa-file-alt"></i> Attendance Report</h2>

  <form method="POST">
      <div class="mb-3">
          <label for="date" class="form-label"><i class="fas fa-calendar-alt"></i> Date</label>
          <input type="date" id="date" name="date" class="form-control" required>
      </div>
      <div class="mb-3">
          <label for="subject_id" class="form-label"><i class="fas fa-book"></i> Subject</label>
          <select id="subject_id" name="subject_id" class="form-select" required>
              <option value="">-- Select Subject --</option>
              <?php while ($subject = $subjects->fetch_assoc()): ?>
                  <option value="<?= $subject['id']; ?>"><?= $subject['subject_name']; ?> - <?= $subject['semester']; ?></option>
              <?php endwhile; ?>
          </select>
      </div>
      <button type="submit" class="btn btn-primary w-100 mt-3">
        <i class="fas fa-search"></i> View Report
      </button>
  </form>

  <?php if ($attendanceRecords && $attendanceRecords->num_rows > 0): ?>
      <h3 class="mt-4"><i class="fas fa-list-alt"></i> Attendance Records for <?= htmlspecialchars($_POST['date']); ?></h3>
      <div class="table-container">
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
      </div>
  <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
      <div class="no-records">No attendance records found for the selected date and subject.</div>
  <?php endif; ?>
</div>

</body>
</html>


</main>
<?php require_once 'partials/footer.php' ?>
