<?php
session_start();
include '../db/database.php';

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

        body {
            background-color: #f7f9fc;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 40px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.7s ease;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5em;
            font-size: 1.8em;
        }

        /* Floating Label Styles */
        .form-group {
            position: relative;
            margin-bottom: 24px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            font-size: 16px;
            color: #333;
            border: 1px solid #d1d9e6;
            background-color: #ffffff;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #4e89f8;
            box-shadow: 0 0 10px rgba(78, 137, 248, 0.3);
        }

        /* Label Animation */
        label {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            background-color: #ffffff;
            padding: 0 4px;
            transition: 0.3s;
            font-size: 1em;
            pointer-events: none;
        }

        .form-control:focus + label,
        .form-control:not(:placeholder-shown) + label {
            top: -8px;
            left: 12px;
            color: #4e89f8;
            font-size: 0.85em;
            font-weight: bold;
        }

        /* Custom Select Styling */
        select.form-control {
            appearance: none;
            background-color: #f1f5f9;
        }

        /* Custom Button Styling */
        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 1em;
            font-weight: bold;
            color: #ffffff;
            background-color: #4e89f8;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .btn-submit:hover {
            background-color: #3c6fc3;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* Slide-in Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(15px);
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
            <!-- Select User Type -->
            <div class="form-group">
                <select id="user_type" name="user_type" class="form-control" required>
                    <option value="" selected disabled hidden></option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                </select>
                <label for="user_type">Select User Type</label>
            </div>

            <!-- Common Fields -->
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

            <!-- Session Selection for Students -->
            <div id="student-fields" style="display: none;">
                <div class="form-group">
                    <select id="session" name="session" class="form-control">
                        <option value="" selected disabled hidden></option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                    </select>
                    <label for="session">Select Session</label>
                </div>

                <div class="form-group">
                    <select id="semester" name="semester" class="form-control">
                        <option value="" selected disabled hidden></option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                        <option value="5th">5th</option>
                        <option value="6th">6th</option>
                        <option value="7th">7th</option>
                        <option value="8th">8th</option>
                    </select>
                    <label for="semester">Select Semester</label>
                </div>
            </div>

            <!-- Additional Fields for Teachers -->
            <div id="teacher-fields" style="display: none;">
                <div class="form-group">
                    <select id="role" name="role" class="form-control">
                        <option value="" selected disabled hidden></option>
                        <option value="CI">Chief Instructor</option>
                        <option value="Instructor">Instructor</option>
                        <option value="Junior Instructor">Junior Instructor</option>
                    </select>
                    <label for="role">Role</label>
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
        // Show/Hide fields based on the user type selection
        document.getElementById('user_type').addEventListener('change', function() {
            const userType = this.value;
            document.getElementById('student-fields').style.display = userType === 'student' ? 'block' : 'none';
            document.getElementById('teacher-fields').style.display = userType === 'teacher' ? 'block' : 'none';
        });
    </script>
</body>

</html>
