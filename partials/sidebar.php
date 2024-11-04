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
    <title>Document</title>
    <!-- External CSS and JS -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
            flex-direction: column; /* Ensures items are stacked vertically */
        }
        .nav-profile {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
            display: flex;
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
            margin-bottom: 10px; /* Adds spacing between links */
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
    </style>
</head>
<body>
<div class="container-fluid page-body-wrapper">
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="../uploads/<?php echo htmlspecialchars($user_photo); ?>" alt="User Photo">
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2"><?php echo htmlspecialchars($_SESSION['name'] ?? 'N/A'); ?></span>
            <span class="text-secondary text-small"><?php echo htmlspecialchars($_SESSION['user_type'] ?? 'N/A'); ?></span>
          </div>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="mdi mdi-bell-outline"></i>
          <span class="menu-title">Announcements</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view_grade_report.php">
          <i class="mdi mdi-chart-line"></i>
          <span class="menu-title">Results</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view_grade_report.php">
          <i class="mdi mdi-cash-multiple"></i>
          <span class="menu-title">Tuition Fees</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view_grade_report.php">
          <i class="mdi mdi-book-open-page-variant"></i>
          <span class="menu-title">Subjects</span>
        </a>
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
