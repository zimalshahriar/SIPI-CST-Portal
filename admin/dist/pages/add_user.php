<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Check if the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Fetch existing sessions from the sessions table
$sessions = [];
$query = $conn->prepare("SELECT session FROM sessions");
$query->execute();
$result = $query->get_result();
while ($row = $result->fetch_assoc()) {
    $sessions[] = $row['session'];
}

// Fetch distinct semesters from the user table
$semesters = [];
$semester_query = $conn->prepare("SELECT DISTINCT semester FROM users WHERE semester IS NOT NULL");
$semester_query->execute();
$semester_result = $semester_query->get_result();
while ($row = $semester_result->fetch_assoc()) {
    $semesters[] = $row['semester'];
}
?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add User - SIPI CST Portal</title>
  <style>
      /* Reset */
      * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
      }

      /* body {
          background: linear-gradient(135deg, #a0c4ff, #bdb2ff);
          font-family: 'Poppins', Arial, sans-serif;
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 100vh;
          color: #333;
      } */

      .container {
        display: grid;
          width: 100%;
          padding: 40px;
          border-radius: 10px;
          animation: fadeIn 0.7s ease;
          margin-top: 2%;
          background-color: #ffffff;
      }

      h2 {
          text-align: center;
          color: #1d4e89;
          font-weight: 600;
          margin-bottom: 1.5em;
          font-size: 1.8em;
      }

      /* Form Group and Label Styling */
      .form-group {
          position: relative;
          margin-bottom: 24px;
      }

      .form-control {
          width: 100%;
          padding: 12px 14px;
          font-size: 16px;
          color: #333;
          background-color: rgba(255, 255, 255, 0.9);
          border: 1px solid transparent;
          border-radius: 8px;
          outline: none;
          box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          transition: border 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
      }

      .form-control:focus {
          border-color: #4e89f8;
          box-shadow: 0 0 8px rgba(78, 137, 248, 0.3);
      }

      label {
          position: absolute;
          left: 16px;
          top: 50%;
          transform: translateY(-50%);
          color: #555;
          font-size: 1em;
          pointer-events: none;
          background-color: rgba(255, 255, 255, 0.85);
          padding: 0 4px;
          transition: all 0.3s ease;
      }

      .form-control:focus + label,
      .form-control:not(:placeholder-shown) + label {
          top: -12px;
          left: 12px;
          color: #4e89f8;
          font-size: 0.85em;
          font-weight: bold;
      }

      /* Select Styling */
      select.form-control {
          appearance: none;
          background-color: rgba(255, 255, 255, 0.9);
          background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%234e89f8" class="bi bi-chevron-down"%3E%3Cpath fill-rule="evenodd" d="M1.5 5.5a.5.5 0 0 1 .7 0l4.5 4.5L11.3 5.5a.5.5 0 0 1 .7.7l-5 5a.5.5 0 0 1-.7 0l-5-5a.5.5 0 0 1 0-.7z"/%3E%3C/svg%3E');
          background-position: right 12px center;
          background-repeat: no-repeat;
          background-size: 1.2em;
      }

      /* Custom Button Styling */
      .btn-submit {
          width: 30%;
          padding: 12px;
          font-size: 1em;
          font-weight: bold;
          color: #ffffff;
          background-color: #1d4e89;
          border: none;
          border-radius: 8px;
          cursor: pointer;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
          transition: background-color 0.3s ease, transform 0.2s;
      }

      .btn-submit:hover {
          background-color: #163d6d;
      }

      .btn-submit:active {
          transform: scale(0.98);
      }

      /* Animation for container */
      @keyframes fadeIn {
          from {
              opacity: 0;
              transform: translateY(10px);
          }
          to {
              opacity: 1;
              transform: translateY(0);
          }
      }
  </style>
</head>
<body>
  <div class="container">
      <h2>Add New User</h2>
      <form action="process_add_user.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
              <select id="user_type" name="user_type" class="form-control" required onchange="toggleFields()">
                  <option value="" selected disabled hidden>Select User Type</option>
                  <option value="student">Student</option>
                  <option value="teacher">Teacher</option>
                  <option value="admin">Admin</option>
              </select>
              <label for="user_type">Select User Type</label>
          </div>

          <div class="form-group">
              <input type="text" class="form-control" id="user_id" name="user_id" placeholder=" " required>
              <label for="user_id">User ID</label>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" id="name" name="name" placeholder=" " required>
              <label for="name">Full Name</label>
          </div>
          <div class="form-group">
              <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
              <label for="email">Email</label>
          </div>
          <div class="form-group">
              <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
              <label for="password">Initial Password</label>
          </div>

          <div id="studentFields" style="display: none;">
              <div class="form-group">
                  <select id="session" name="session" class="form-control">
                      <option value="" selected disabled>Select Session</option>
                      <?php foreach ($sessions as $session): ?>
                          <option value="<?= htmlspecialchars($session) ?>"><?= htmlspecialchars($session) ?></option>
                      <?php endforeach; ?>
                  </select>
                  <label for="session">Session</label>
              </div>

              <div class="form-group">
                  <select id="semester" name="semester" class="form-control">
                      <option value="" selected disabled>Select Semester</option>
                      <?php foreach ($semesters as $semester): ?>
                          <option value="<?= htmlspecialchars($semester) ?>"><?= htmlspecialchars($semester) ?></option>
                      <?php endforeach; ?>
                  </select>
                  <label for="semester">Semester</label>
              </div>
          </div>

          <div id="teacherFields" style="display: none;">
              <div class="form-group">
                  <!-- <input type="text" class="form-control" id="role" name="role" placeholder=" "> -->
                  <label for="role"></label>
                  <select class="form-select" id="role" name="role">
                        <option value="CI">Chief Instructor</option>
                        <option value="Instructor">Instructor</option>
                        <option value="Junior Instructor">Junior Instructor</option>
                    </select>
              </div>
          </div>

          <div class="form-group">
              <input type="file" class="form-control" id="photo" name="photo">
              <label for="photo">Upload Photo</label>
          </div>

          <button type="submit" class="btn-submit">Add User</button>
      </form>
  </div>

  <script>
      function toggleFields() {
          const userType = document.getElementById("user_type").value;
          document.getElementById("studentFields").style.display = userType === "student" ? "block" : "none";
          document.getElementById("teacherFields").style.display = userType === "teacher" ? "block" : "none";
      }
  </script>
</body>
</html>
</main>
<?php require_once 'partials/footer.php' ?>
