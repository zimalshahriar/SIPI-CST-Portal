<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';
?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teachers Section</title>
  <link href="../../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Additional Custom CSS */
    .title {
      text-align: center;
      margin-bottom: 30px;
      color: #00818E;
      font-family: 'Times New Roman', Times, serif;
    }
    .teacher-card img {
      border-radius: 50%;
      width: 100px;
      height: 100px;
      object-fit: cover;
    }
    .teacher-card {
      transition: transform 0.3s;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 400px;
      height: 350px;
    }
    .teacher-card:hover {
      transform: scale(1.05);
    }
    .teacher-name {
      font-size: 1.25rem;
      font-weight: bold;
    }
    .teacher-position {
      font-size: 1rem;
      color: #6c757d;
    }
    .contact-info {
      display: none;
      font-size: 0.9rem;
      color: #333;
      margin-top: 10px;
      transition: opacity 0.3s;
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <h2 class="title">Our Department Teachers</h2>
    <div class="row">
      <!-- Teacher Card 1 -->
      <div class="col-md-4 mb-4">
        <div class="card teacher-card text-center p-3">
          <img src="../../../image/teacher.jpeg" alt="Teacher 1" class="mx-auto mb-3">
          <div class="card-body">
            <h5 class="teacher-name">Shahinur Islam Shahin</h5>
            <p class="teacher-position">Chief Instructor</p>
            <p class="card-text">Specializes in Networking and Cybersecurity.</p>
            <button class="btn btn-primary btn-sm" onclick="toggleContact(this)">View Contact</button>
            <p class="contact-info">Email: shahin@department.edu<br>Phone: (123) 456-7890</p>
          </div>
        </div>
      </div>
      
      <!-- Teacher Card 2 -->
      <div class="col-md-4 mb-4">
        <div class="card teacher-card text-center p-3">
          <img src="../../../image/teacher.jpeg" alt="Teacher 2" class="mx-auto mb-3">
          <div class="card-body">
            <h5 class="teacher-name">Masood Raana</h5>
            <p class="teacher-position">Junior Instructor</p>
            <p class="card-text">Expert in Web Development and UI/UX Design.</p>
            <button class="btn btn-primary btn-sm" onclick="toggleContact(this)">View Contact</button>
            <p class="contact-info">Email: masood@department.edu<br>Phone: (123) 456-7891</p>
          </div>
        </div>
      </div>
      
      <!-- Teacher Card 3 -->
      <div class="col-md-4 mb-4">
        <div class="card teacher-card text-center p-3">
          <img src="../../../image/teacher.jpeg" alt="Teacher 3" class="mx-auto mb-3">
          <div class="card-body">
            <h5 class="teacher-name">Palash Biswas</h5>
            <p class="teacher-position">Instructor</p>
            <p class="card-text">Focused on Software Engineering</p>
            <button class="btn btn-primary btn-sm" onclick="toggleContact(this)">View Contact</button>
            <p class="contact-info">Email: palash@department.edu<br>Phone: (123) 456-7892</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle (including Popper) -->
  <script src="../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleContact(button) {
      const contactInfo = button.nextElementSibling;
      if (contactInfo.style.display === "none" || !contactInfo.style.display) {
        contactInfo.style.display = "block";
        contactInfo.style.opacity = "1";
        button.textContent = "Hide Contact";
      } else {
        contactInfo.style.opacity = "0";
        setTimeout(() => { contactInfo.style.display = "none"; }, 300);
        button.textContent = "View Contact";
      }
    }
  </script>
</body>
</html>

</main>
<?php require_once 'partials/footer.php' ?>
