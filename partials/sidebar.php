<?php 
session_start();
// Get user photo
$user_photo = isset($_SESSION['photo']) ? $_SESSION['photo'] : 'default.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <!-- External CSS and JS -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .sidebar {
            background: #c8d7e6;
            min-height: 100vh;
            padding: 20px;
            width: 300px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 99;
            padding-top: 70px;
        }
        .nav {
            display: flex;
            flex-direction: column;
        }
        .nav-profile {
            
            margin-bottom: 15px;
            align-items: center;
            width: 100%;   
        }
        .profile-item {
            display: flex;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
            align-items: center;
            width: 100%;

        }
        .nav-profile-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }
        .nav-profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .nav-link {
            color: #000000;
            padding: 12px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            text-decoration: none;
        }
        .nav-link:hover, .nav-link.active {
            background: #7366ff;
            color: white;
        }
        .nav-link i {
            margin-right: 10px;
            font-size: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid page-body-wrapper">
  <!-- Toggle button for smaller screens -->
  <button class="btn btn-primary d-md-none mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
    Toggle Sidebar
  </button>

  <!-- Sidebar -->
  <nav class="sidebar sidebar-offcanvas collapse show" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <div  class="profile-item">
          <div class="nav-profile-image">
            <img src="../uploads/<?php echo htmlspecialchars($user_photo); ?>" alt="User Photo">
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2"><?php echo htmlspecialchars($_SESSION['name'] ?? 'N/A'); ?></span>
            <span class="text-secondary text-small"><?php echo htmlspecialchars($_SESSION['user_type'] ?? 'N/A'); ?></span>
          </div>
          </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="announcements.php">
          <i class="mdi mdi-bell-outline"></i>
          <span class="menu-title">Announcements</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="grade_report.php">
          <i class="mdi mdi-chart-line"></i>
          <span class="menu-title">Results</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pay_tuition.php">
          <i class="mdi mdi-cash-multiple"></i>
          <span class="menu-title">Tuition Fees</span>
        </a>
      </li>
      <li class="nav-item">
  <a class="nav-link" data-bs-toggle="collapse" href="#informationDropdown" role="button" aria-expanded="false" aria-controls="informationDropdown">
    <i class="mdi mdi-information-outline"></i>
    <span class="menu-title">Informations</span>
    <i class="mdi mdi-chevron-down" style="margin-left:auto;"></i>
  </a>
  <div class="collapse" id="informationDropdown">
    <ul class="nav flex-column ms-3">
      <li class="nav-item">
        <a class="nav-link" href="subject.php">
          <i class="mdi mdi-book-multiple"></i>
          Subject
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="teachers.php">
          <i class="mdi mdi-account-multiple"></i>
          Teachers
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="routine.php">
          <i class="mdi mdi-calendar-clock"></i>
          Routine
        </a>
      </li>
    </ul>
  </div>
</li>
      <li class="nav-item">
        <a class="nav-link" href="settings.php">
          <i class="mdi mdi-cog"></i>
          <span class="menu-title">Settings</span>
        </a>
      </li>
    </ul>
  </nav>
</div>
</body>
</html>