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
</head>

<body>
  <div class="container mt-5">
    <h2>Your Class Schedule for Semester <?= $student_semester; ?></h2>

    <!-- Class Schedule Table -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Subject</th>
          <th>Teacher</th>
          <th>Day</th>
          <th>Time</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['subject_name'] . "</td>";
            echo "<td>" . $row['teacher_name'] . "</td>";
            echo "<td>" . $row['day'] . "</td>";
            echo "<td>" . $row['start_time'] . " - " . $row['end_time'] . "</td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No class schedule found for this semester.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>
<?php require_once 'partials/footer.php' ?>

<?php
$stmt->close();
?>