<?php
// include './partials/header.php';
// Authentication Check For Teachers
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
  header("Location: ../login.php"); // Redirect if not a teacher
  exit;
}
?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
    <div class="nav-profile-image">
    <img src="../uploads/logo.jpg?= $user_photo; ?>" alt="User Photo">
      <span class="login-status online"></span>
      <!--change to offline or busy as needed-->
    </div>
    <div class="nav-profile-text d-flex flex-column">
      <span class="font-weight-bold mb-2"><?php echo $_SESSION['name']; ?></span>
      <span class="text-secondary text-small"><?php echo $_SESSION['user_type']; ?></span>
    </div>
    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">
    <span class="menu-title">Dashboard</span>
    <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
    <span class="menu-title">Announcements</span>
    <i class="menu-arrow"></i>
    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item"> <a class="nav-link" href="announcements.php">Add Announcements</a></li>
      <li class="nav-item"> <a class="nav-link" href="manage_announcements.php">Manage Announcements</a></li>
    </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="publish_grade_report.php">
    <span class="menu-title">Publish Marks</span>
    <i class="mdi mdi-contacts menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
    <span class="menu-title">Class Schedule</span>
    <i class="menu-arrow"></i>
    <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic2">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item"> <a class="nav-link" href="add_class_schedule.php">Add Class Schedule</a></li>
      <li class="nav-item"> <a class="nav-link" href="class_schedule_management.php">Manaage Class Schedule</a></li>
    </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="settings.php">
    <span class="menu-title">Settings</span>
    <i class="mdi mdi-chart-bar menu-icon"></i>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="pages/tables/basic-table.html">
    <span class="menu-title">Tables</span>
    <i class="mdi mdi-table-large menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
    <span class="menu-title">Sample Pages</span>
    <i class="menu-arrow"></i>
    <i class="mdi mdi-medical-bag menu-icon"></i>
        </a>
        <div class="collapse" id="general-pages">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
      <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
      <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
      <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
      <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
    </ul> 
        </div> -->

  </nav>