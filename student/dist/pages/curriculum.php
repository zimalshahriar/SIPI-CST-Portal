<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Department Curriculum</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .subject-card {
      position: relative;
      overflow: hidden;
      border: none;
      border-radius: 15px;
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
      width: 100%;
      height: 100%;
    }

    .subject-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .subject-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .subject-card .card-body {
      padding: 20px;
    }

    .subject-card .subject-info {
      position: absolute;
      bottom: 0;
      background: rgba(0, 0, 0, 0.8);
      color: #fff;
      width: 100%;
      padding: 15px;
      opacity: 0;
      transform: translateY(100%);
      transition: opacity 0.3s, transform 0.3s;
    }

    .subject-card:hover .subject-info {
      opacity: 1;
      transform: translateY(0);
    }

    .content-wrapper {
      padding: 20px;
    }

    @media (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
      }
    }

    @media (max-width: 576px) {
      .subject-card img {
        height: 150px;
      }

      .subject-info {
        position: relative;
        background: rgba(0, 0, 0, 0.8);
        padding: 10px;
        bottom: unset;
      }
    }
  </style>
</head>
<body>
  <div class="content-wrapper">
    <h2 class="text-center">Department Curriculum</h2>
    <div class="container my-5">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        
        <!-- Card 1 -->
        <div class="col">
          <div class="card subject-card">
            <img src="https://via.placeholder.com/350x300" class="card-img-top" alt="Subject Image">
            <div class="card-body">
              <h5 class="card-title">Subject 1</h5>
              <p class="card-text">Introduction to the basics of Subject 1.</p>
            </div>
            <div class="subject-info">
              <p><strong>Credits:</strong> 3</p>
              <p><strong>Faculty:</strong> Dr. ABC</p>
              <p><strong>Schedule:</strong> Mon/Wed/Fri, 10:00 AM - 12:00 PM</p>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col">
          <div class="card subject-card">
            <img src="https://via.placeholder.com/350x300" class="card-img-top" alt="Subject Image">
            <div class="card-body">
              <h5 class="card-title">Subject 2</h5>
              <p class="card-text">Intermediate concepts in Subject 2.</p>
            </div>
            <div class="subject-info">
              <p><strong>Credits:</strong> 4</p>
              <p><strong>Faculty:</strong> Prof. XYZ</p>
              <p><strong>Schedule:</strong> Tue/Thu, 2:00 PM - 4:00 PM</p>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col">
          <div class="card subject-card">
            <img src="https://via.placeholder.com/350x300" class="card-img-top" alt="Subject Image">
            <div class="card-body">
              <h5 class="card-title">Subject 3</h5>
              <p class="card-text">Advanced study in Subject 3.</p>
            </div>
            <div class="subject-info">
              <p><strong>Credits:</strong> 4</p>
              <p><strong>Faculty:</strong> Dr. DEF</p>
              <p><strong>Schedule:</strong> Mon/Wed/Fri, 1:00 PM - 3:00 PM</p>
            </div>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="col">
          <div class="card subject-card">
            <img src="https://via.placeholder.com/350x300" class="card-img-top" alt="Subject Image">
            <div class="card-body">
              <h5 class="card-title">Subject 4</h5>
              <p class="card-text">Explorative approach in Subject 4.</p>
            </div>
            <div class="subject-info">
              <p><strong>Credits:</strong> 4</p>
              <p><strong>Faculty:</strong> Dr. GHI</p>
              <p><strong>Schedule:</strong> Tue/Thu, 10:00 AM - 12:00 PM</p>
            </div>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="col">
          <div class="card subject-card">
            <img src="https://via.placeholder.com/350x300" class="card-img-top" alt="Subject Image">
            <div class="card-body">
              <h5 class="card-title">Subject 4</h5>
              <p class="card-text">Explorative approach in Subject 4.</p>
            </div>
            <div class="subject-info">
              <p><strong>Credits:</strong> 4</p>
              <p><strong>Faculty:</strong> Dr. GHI</p>
              <p><strong>Schedule:</strong> Tue/Thu, 10:00 AM - 12:00 PM</p>
            </div>
          </div>
        </div>

         <!-- Card 6 -->
         <div class="col">
          <div class="card subject-card">
            <img src="https://via.placeholder.com/350x300" class="card-img-top" alt="Subject Image">
            <div class="card-body">
              <h5 class="card-title">Subject 4</h5>
              <p class="card-text">Explorative approach in Subject 4.</p>
            </div>
            <div class="subject-info">
              <p><strong>Credits:</strong> 4</p>
              <p><strong>Faculty:</strong> Dr. GHI</p>
              <p><strong>Schedule:</strong> Tue/Thu, 10:00 AM - 12:00 PM</p>
            </div>
          </div>
        </div>

        <!-- Add additional cards as needed -->
        
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php require_once 'partials/footer.php' ?>
