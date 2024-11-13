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
  <title>Document</title>

  <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>

  <div class="m-4">
    <h1 class="text-center fs-2 fw-bold  mb-4">📆 Class Schedule</h1>

    <div class="hidden rounded overflow-hidden">
      <table class="table rounded table-hover">
        <thead class="p-2">
          <tr class="text-center table-primary">
            <th scope="col">SUBJECT</th>
            <th scope="col">DAY</th>
            <th scope="col">START TIME</th>
            <th scope="col">END TIME</th>
            <th scope="col">TEACHERS NAME</th>
            <th scope="col">SEMESTER</th>
          </tr>
        </thead>
  
        <tbody>
          <tr class="text-center">
            <td>English</td>
            <td>Monday</td>
            <td>06:10</td>
            <td>07:10</td>
            <td>Masud Rana</td>
            <td>7th</td>
          </tr>
  
          <tr class="text-center">
            <td>Bangla</td>
            <td>Tuesday</td>
            <td>07:10</td>
            <td>08:10</td>
            <td>Shahinur Islam</td>
            <td>6th</td>
          </tr>
  
          <tr class="text-center">
            <td>Math</td>
            <td>Wednesday</td>
            <td>09:10</td>
            <td>10:10</td>
            <td>Polash Chandra</td>
            <td>4th</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

<?php require_once 'partials/footer.php' ?>
