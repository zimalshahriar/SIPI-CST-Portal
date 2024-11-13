<?php
session_start();
require_once 'partials/header.php' ?>
<?php require_once 'partials/navbar.php' ?>
<?php require_once 'partials/sidebar.php'?>
  <main class="app-main">
  <?php

// Check if the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Fetch all users from the database
$result = $conn->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - SIPI CST Portal</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            color: #2c3e50;
        }

        h2 {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 30px;
        }

        .container {
            border-radius: 0px;
            padding: 30px;
            max-width: 100%;
            animation: fadeIn 0.7s ease;

        }

        /* Table Styling */
        .table {
            border-radius: 4px;
            overflow: hidden;
            margin-top: 20px;
        }

        .table thead {
            background-color: #5d6d7e;
            color: #fff;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
            padding: 10px;
        }

        .table tbody tr:hover {
            background-color: #f4f6f7;
            transition: background-color 0.3s;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #1d4e89;
            border: none;
            color: #fff;
            border-radius: 25px;
            padding: 8px 20px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #163d6d;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
            color: #fff;
            border-radius: 25px;
            padding: 8px 20px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 1.5rem;
            }

            .table {
                font-size: 0.9rem;
            }

            .btn {
                padding: 5px 15px;
                font-size: 12px;
                border-radius: 20px;
            }

            .table th, .table td {
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .table thead {
                display: none;
            }

            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }

            .table td {
                padding: 10px;
                text-align: right;
                position: relative;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                text-align: left;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Manage Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through all users and display in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td data-label='User ID'>" . $row['user_id'] . "</td>";
                    echo "<td data-label='Name'>" . $row['name'] . "</td>";
                    echo "<td data-label='Email'>" . $row['email'] . "</td>";
                    echo "<td data-label='User Type'>" . $row['user_type'] . "</td>";
                    echo "<td data-label='Actions'>";
                    echo "<a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a> ";
                    echo "<a href='delete_user.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</main>
<?php require_once 'partials/footer.php' ?>
