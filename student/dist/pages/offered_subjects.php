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
  <title>Book Collection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Arial', sans-serif;
    }

    .book-card {
      position: relative;
      overflow: hidden;
      border: 1px solid #ccc;
      border-radius: 10px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 400px; /* Set fixed height to mimic a book */
      width: 100%; /* Let the card take up 100% width of its parent */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .book-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .book-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px;
    }

    .book-card .card-body {
      position: absolute;
      bottom: 10px;
      left: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      padding: 15px;
      border-radius: 0 0 10px 10px;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }

    .book-card:hover .card-body {
      opacity: 1;
    }

    .book-card .card-title {
      font-size: 1.25rem;
      font-weight: bold;
    }

    .book-card .card-text {
      font-size: 0.9rem;
      color: #dcdcdc;
    }

    .content-wrapper {
      padding: 40px;
    }

    .book-container {
      margin-top: 30px;
    }

    .book-container h2 {
      font-size: 2rem;
      text-align: center;
      margin-bottom: 30px;
    }

  
    .book-container .row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px; 
    }

    .book-container .col {
      flex: 1;
      max-width: 300px; 
      min-width: 250px; 
    }

    /* Responsive for mobile */
    @media (max-width: 768px) {
      .book-card img {
        height: 300px;
      }
    }
    
    @media (max-width: 576px) {
      .book-card img {
        height: 200px; 
      }
    }
  </style>
</head>
<body>
  <div class="content-wrapper">
    <div class="book-container">
      <h2>Our Book Collection</h2>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- Book Card 1 -->
        <div class="col">
          <div class="card book-card">
            <img src="../../../image/book.jpg" class="card-img-top" alt="Book Cover 1">
            <div class="card-body">
              <h5 class="card-title">system analysis and design</h5>
              <p class="card-text">Description</p>
            </div>
          </div>
        </div>

        <!-- Book Card 2 -->
        <div class="col">
          <div class="card book-card">
            <img src="../../../image/book2.jpg" class="card-img-top" alt="Book Cover 2">
            <div class="card-body">
              <h5 class="card-title">network administration and service</h5>
              <p class="card-text">Description</p>
            </div>
          </div>
        </div>

        <!-- Book Card 3 -->
        <div class="col">
          <div class="card book-card">
            <img src="../../../image/book3.jpg" class="card-img-top" alt="Book Cover 3">
            <div class="card-body">
              <h5 class="card-title">Apps Development Project</h5>
              <p class="card-text">Description</p>
            </div>
          </div>
        </div>

        <!-- Book Card 4 -->
        <div class="col">
          <div class="card book-card">
            <img src="../../../image/book4.jpg" class="card-img-top" alt="Book Cover 4">
            <div class="card-body">
              <h5 class="card-title">Cyber Security & Ethics</h5>
              <p class="card-text">Description</p>
            </div>
          </div>
        </div>

        <!-- Book Card 5 -->
        <div class="col">
          <div class="card book-card">
            <img src="../../../image/book5.jpg" class="card-img-top" alt="Book Cover 5">
            <div class="card-body">
              <h5 class="card-title">Innovation & Entrepreneurship</h5>
              <p class="card-text">Description</p>
            </div>
          </div>
        </div>
<!-- Book Card 6 -->
        <div class="col">
          <div class="card book-card">
            <img src="../../../image/book5.jpg" class="card-img-top" alt="Book Cover 5">
            <div class="card-body">
              <h5 class="card-title">Network Security System</h5>
              <p class="card-text">Des
                cription
              </p>
            </div>
          </div>
        </div>

        <!-- Book Card 7 -->
        <div class="col">
          <div class="card book-card">
            <img src="../../../image/book6.jpg" class="card-img-top" alt="Book Cover 6">
            <div class="card-body">
              <h5 class="card-title">E-commerce and CMS</h5>
              <p class="card-text">Description</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
</main>

<?php require_once 'partials/footer.php'; ?>
