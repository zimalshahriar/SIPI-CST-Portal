<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';
?>
<main class="app-main">
<?php
ob_start(); // Start output buffering

// Check if the user is a teacher
// if ($_SESSION['user_type'] !== 'teacher') {
//     header('Location: index.php');
//     exit;
// }

// Fetch all teachers for the dropdown
$teachers = $conn->query("SELECT name FROM users WHERE user_type = 'teacher'");

// Handle form submission to add class schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_id = $_POST['subject_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $teacher_name = $_POST['teacher_name'];
    $semester = $_POST['semester'];

    $stmt = $conn->prepare("INSERT INTO class_schedule (subject_id, day, start_time, end_time, teacher_name, semester) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssss', $subject_id, $day, $start_time, $end_time, $teacher_name, $semester);
    $stmt->execute();
    $stmt->close();
    // header('Location: class_schedule_management.php');
}
ob_end_flush(); // End output buffering and flush output

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <title>Add Class Schedule - SIPI CST Portal</title>
    <style>
        /* General Styling */
        body {
            background-color: #eef2f7;
            font-family: 'Poppins', sans-serif;
            color: #333;
            padding: 0;
            margin: 0;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }



        /* Card Styling */
        .card {
            border-radius: 0px;
            padding: 41px;
            width: 100%;
            max-width: 1500px;
            background: #fff;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2rem;
            color: #2c3e50;
            font-weight: 600;
        }

        /* Grid Styling */
        .form-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(2, 1fr);
        }

        .form-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            background-color: #f9f9f9;
        }

        .form-section h3 {
            font-size: 1.2rem;
            color: #007bff;
            margin-bottom: 1rem;
            font-weight: 500;
            text-align: center;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
        }

        .form-label {
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        /* Full-width Button Styling */
        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="">
    <div class="card">
        <h2>Add Class Schedule</h2>
        <form method="POST">
            <div class="form-grid">
                <div class="form-section">
                    <h3>Class Details</h3>
                    <div class="form-group">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-select" id="subject_id" name="subject_id" required>
                            <option value="" disabled selected>Select Subject</option>
                            <?php
                            $subjects = $conn->query("SELECT id, subject_name FROM subjects");
                            while ($row = $subjects->fetch_assoc()): ?>
                                <option value="<?= $row['id']; ?>"><?= $row['subject_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester" required>
                            <option value="" disabled selected>Select Semester</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                            <option value="5th">5th</option>
                            <option value="6th">6th</option>
                            <option value="7th">7th</option>
                            <option value="8th">8th</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Schedule Details</h3>
                    <div class="form-group">
                        <label for="day" class="form-label">Day</label>
                        <select class="form-select" id="day" name="day" required>
                            <option value="" disabled selected>Select Day</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                </div>
            </div>

            <div class="form-section mt-3">
                <h3>Instructor</h3>
                <div class="form-group">
                    <label for="teacher_name" class="form-label">Teacher Name</label>
                    <select class="form-select" id="teacher_name" name="teacher_name" required>
                        <option value="" disabled selected>Select Teacher</option>
                        <?php while ($row = $teachers->fetch_assoc()): ?>
                            <option value="<?= $row['name']; ?>"><?= $row['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary mt-4">Add Schedule</button>
        </form>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</main>
<?php require_once './partials/footer.php'; ?>



