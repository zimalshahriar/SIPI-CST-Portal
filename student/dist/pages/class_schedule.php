<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Ensure the user is a student
if ($_SESSION['user_type'] !== 'student') {
  header('Location: index.php');
  exit;
}

// Get the student's semester from the session variable
$student_semester = $_SESSION['semester'];

// Fetch class schedule based on the student's semester
$query = "SELECT DISTINCT cs.*, s.subject_name, t.name as teacher_name 
        FROM class_schedule cs
        JOIN subjects s ON cs.subject_id = s.id
        JOIN users t ON cs.teacher_name = t.name  -- Join on teacher_name
        WHERE cs.semester = ?";

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_semester); // Bind the semester value
$stmt->execute();
$result = $stmt->get_result();

// Check if query executed successfully
if ($stmt->error) {
  echo "Error: " . $stmt->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Class Schedule - SIPI CST Portal</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f4f7fb;
      font-family: 'Arial', sans-serif;
    }
    .container {
      margin-top: 30px;
    }
    .table {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      background-color: #fff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .table th, .table td {
      text-align: center;
      vertical-align: middle;
    }
    .table th {
      background-color: #007bff;
      color: #fff;
    }
    .table td {
      background-color: #f9f9f9;
    }
    h2 {
      font-size: 2rem;
      color: #333;
      font-weight: bold;
    }
    .alert-info {
      background-color: #e9f7fd;
      color: #31708f;
      border: 1px solid #bce8f1;
    }
    .card-header {
      background-color: #007bff;
      color: white;
      font-size: 1.5rem;
    }
    .card-body {
      padding: 20px;
    }
    .card-footer {
      background-color: #f1f1f1;
      text-align: center;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #004085;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card mb-4">
      <div class="card-header">
        <h2>Your Class Schedule for Semester <?= htmlspecialchars($student_semester); ?></h2>
      </div>
      <div class="card-body">
        <?php if ($result->num_rows > 0): ?>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Day</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['subject_name']); ?></td>
                  <td><?= htmlspecialchars($row['teacher_name']); ?></td>
                  <td><?= htmlspecialchars($row['day']); ?></td>
                  <td><?= htmlspecialchars($row['start_time']); ?> - <?= htmlspecialchars($row['end_time']); ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="alert alert-info">
            <strong>No Schedule Found</strong> for this semester. Please contact your administrator for further assistance.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
require_once 'partials/footer.php';
$stmt->close();
?>
