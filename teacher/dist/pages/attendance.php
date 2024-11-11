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
  <style>
      /* Global Styles */
      body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: #e9ecef;
          color: #212529;
          margin: 0;
      }
      
      .container {
          max-width: 900px;
          margin-top: 5rem;
          padding: 2rem;
          background: #ffffff;
          border-radius: 5px;
      }

      h2 {
          color: #495057;
          font-weight: 600;
          text-align: center;
          margin-bottom: 1.5rem;
      }

      /* Form Styles */
      .form-label {
          color: #495057;
          font-weight: 500;
      }

      .form-select, .form-control {
          border-radius: 8px;
      }

      .btn-primary {
          background-color: #007bff;
          border: none;
          padding: 0.6rem 1.5rem;
          border-radius: 4px;
          font-size: 1rem;
          font-weight: 500;
          transition: background-color 0.3s ease;
      }

      .btn-primary:hover {
          background-color: #007bff;
      }

      /* Card Grid */
      #studentsList {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
          gap: 1.5rem;
          margin-top: 1.5rem;
      }

      .student-card {
          background: #f8f9fa;
          padding: 1rem;
          border-radius: 10px;
          box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease;
      }

      .student-card:hover {
          transform: translateY(-5px);
      }

      .student-card h5 {
          font-size: 1rem;
          font-weight: 600;
          color: #495057;
          margin-bottom: 0.75rem;
      }

      .student-card input[type="checkbox"] {
          margin-top: 0.5rem;
          accent-color: #6c63ff;
      }

      /* Responsive Adjustments */
      @media (max-width: 600px) {
          .container {
              padding: 1.5rem;
          }

          .btn-primary {
              font-size: 0.9rem;
              padding: 0.5rem 1.2rem;
          }

          #studentsList {
              grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
          }
      }
  </style>
</head>
<body>
<div class="container">
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

      <button type="button" class="btn btn-primary w-30 mt-4" id="fetchStudents">Fetch Students</button>
      <div id="studentsList"></div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

</main>
<?php require_once 'partials/footer.php' ?>
