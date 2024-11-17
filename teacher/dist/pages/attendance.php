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

  echo "<script>alert('Attendance recorded successfully'); window.location.href='attendance.php';</script>";
  exit;
}
?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance - SIPI CST Portal</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Global Styles */
    body {
      background-color: #f4f7fc;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(to left, #f6fcfb, #f9fcff );

    }

    /* Form Card */
    .form-container {
      max-width: 900px;
      margin: auto;
      margin-top: 50px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .form-container h2 {
      color: #333;
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
    }

    /* Form Elements */
    .form-label {
      font-weight: 500;
      color: #555;
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
      padding: 12px 20px;
      font-weight: bold;
      letter-spacing: 0.5px;
      transition: background-color 0.3s, transform 0.2s;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      transform: scale(1.05);
    }

    /* Spinner */
    #loadingSpinner {
      display: none;
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
  </style>
</head>
<body>

<!-- Main Content -->
<div class="container form-container">
  <h2><i class="fas fa-calendar-check"></i> Mark Attendance</h2>
  <?php if (isset($_GET['message'])): ?>
      <div class="alert alert-success text-center"><?= $_GET['message']; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="date" class="form-label"><i class="fas fa-calendar-alt"></i> Date</label>
        <input type="date" id="date" name="date" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label for="subject_id" class="form-label"><i class="fas fa-book"></i> Subject</label>
        <select id="subject_id" name="subject_id" class="form-select" required>
          <option value="">-- Select Subject --</option>
          <?php while ($subject = $subjects->fetch_assoc()): ?>
              <option value="<?= $subject['id']; ?>"><?= $subject['subject_name']; ?> - <?= $subject['semester']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
    </div>
    <button type="button" class="btn btn-primary w-100 mt-3" id="fetchStudents">
      <i class="fas fa-users"></i> Fetch Students
    </button>
    <div id="loadingSpinner" class="text-center mt-3">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div id="studentsList" class="mt-4"></div>
  </form>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '#fetchStudents', function () {
  const subjectId = $('#subject_id').val();
  if (subjectId) {
      $('#loadingSpinner').show();
      $.ajax({
          url: 'fetch_students.php',
          method: 'POST',
          data: { subject_id: subjectId },
          success: function (response) {
              $('#loadingSpinner').hide();
              $('#studentsList').html(response);
          },
          error: function () {
              $('#loadingSpinner').hide();
              alert('An error occurred while fetching students.');
          }
      });
  } else {
      alert('Please select a subject.');
  }
});
</script>
</body>
</html>


</main>
<?php require_once 'partials/footer.php' ?>
