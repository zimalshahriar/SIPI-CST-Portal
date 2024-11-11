<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';
?>
<main class="app-main">
<?php

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Check if the grade report ID is provided
if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$report_id = $_GET['id'];

// Fetch the grade report data
$reportQuery = $conn->prepare("SELECT * FROM grade_reports WHERE id = ?");
$reportQuery->bind_param("i", $report_id);
$reportQuery->execute();
$gradeReport = $reportQuery->get_result()->fetch_assoc();

if (!$gradeReport) {
    echo "Grade report not found.";
    exit;
}

// Handle form submission to update the report
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendance = $_POST['attendance'];
    $mid_exam = $_POST['mid_exam'];
    $class_test = $_POST['class_test'];
    $quiz_test = $_POST['quiz_test'];
    $performance_assessment = $_POST['performance_assessment'];
    $assignment_homework = $_POST['assignment_homework'];
    $total_tc = $mid_exam + $class_test + $quiz_test + $performance_assessment + $assignment_homework;

    $experiment = $_POST['experiment'];
    $homework = $_POST['homework'];
    $error = $_POST['error'];
    $evaluation = $_POST['evaluation'];
    $discussion_solution = $_POST['discussion_solution'];
    $additional_hours = $_POST['additional_hours'];
    $total_pc = $experiment + $homework + $error + $evaluation + $discussion_solution + $additional_hours;

    $remarks = $_POST['remarks'];

    // Update the grade report in the database
    $updateQuery = $conn->prepare("UPDATE grade_reports SET attendance = ?, mid_exam = ?, class_test = ?, quiz_test = ?, performance_assessment = ?, assignment_homework = ?, total_tc = ?, experiment = ?, homework = ?, error = ?, evaluation = ?, discussion_solution = ?, additional_hours = ?, total_pc = ?, remarks = ? WHERE id = ?");
    $updateQuery->bind_param("ddddddddddddddsi", $attendance, $mid_exam, $class_test, $quiz_test, $performance_assessment, $assignment_homework, $total_tc, $experiment, $homework, $error, $evaluation, $discussion_solution, $additional_hours, $total_pc, $remarks, $report_id);

    if ($updateQuery->execute()) {
        echo "<script>alert('Grade report updated successfully!'); window.location.href='manage_grade_report.php';</script>";
        exit;
    } else {
        echo "Error updating report.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Grade Report - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f0f4f8;
            color: #333;
        }

        /* Styling Buttons */
        .btn-success {
            background: linear-gradient(45deg, #28a745, #218838);
            border: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-success:hover {
            background: linear-gradient(45deg, #218838, #28a745);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f1f1f1;
            color: #333;
            border: 1px solid #ddd;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #ddd;
            color: #222;
        }

        .form-control:focus {
            border-color: #5c6bc0;
            box-shadow: 0 0 5px rgba(92, 107, 192, 0.5);
        }

        /* Colorful Grid Sections */
        .grade-section {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2, h5 {
            font-weight: bold;
            color: #444;
        }

        /* Advanced CSS Grid Layout */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Responsive columns */
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        /* Form Grid with Colorful Borders */
        .attendance-section {
            border-left: 5px solid #4caf50;
            background-color: #e8f5e9;
        }

        .tc-section {
            border-left: 5px solid #2196f3;
            background-color: #e3f2fd;
        }

        .pc-section {
            border-left: 5px solid #ff9800;
            background-color: #fff3e0;
        }

        /* Hover effect for input fields */
        .form-control:hover {
            border-color: #5c6bc0;
            box-shadow: 0 0 10px rgba(92, 107, 192, 0.2);
        }

        /* Button container styling */
        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr; /* Single column layout for small screens */
            }
            .grade-section .form-grid {
                grid-template-columns: 1fr; /* Single column for each section on small screens */
            }
        }
    </style>
</head>
<body>

<div class="container mt-0">
    <div class="card p-4">
        <h2>Edit Grade Report</h2>

        <!-- Edit Form for Grade Report -->
        <form method="POST">
            <!-- Attendance Section with Color -->
            <div class="attendance-section grade-section">
                <h5>Attendance</h5>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="attendance" class="form-label">Attendance</label>
                        <input type="number" id="attendance" name="attendance" class="form-control" step="0.01" min="0" max="100" value="<?= $gradeReport['attendance']; ?>" required>
                    </div>
                </div>
            </div>

            <!-- TC Grades Section -->
            <div class="tc-section grade-section">
                <h5>TC Grades</h5>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="mid_exam" class="form-label">Mid Exam</label>
                        <input type="number" id="mid_exam" name="mid_exam" class="form-control" step="0.01" value="<?= $gradeReport['mid_exam']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="class_test" class="form-label">Class Test</label>
                        <input type="number" id="class_test" name="class_test" class="form-control" step="0.01" value="<?= $gradeReport['class_test']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="quiz_test" class="form-label">Quiz Test</label>
                        <input type="number" id="quiz_test" name="quiz_test" class="form-control" step="0.01" value="<?= $gradeReport['quiz_test']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="performance_assessment" class="form-label">Performance Assessment</label>
                        <input type="number" id="performance_assessment" name="performance_assessment" class="form-control" step="0.01" value="<?= $gradeReport['performance_assessment']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="assignment_homework" class="form-label">Assignment/Homework</label>
                        <input type="number" id="assignment_homework" name="assignment_homework" class="form-control" step="0.01" value="<?= $gradeReport['assignment_homework']; ?>">
                    </div>
                </div>
            </div>

            <!-- PC Grades Section -->
            <div class="pc-section grade-section">
                <h5>PC Grades</h5>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="experiment" class="form-label">Experiment</label>
                        <input type="number" id="experiment" name="experiment" class="form-control" step="0.01" value="<?= $gradeReport['experiment']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="homework" class="form-label">Homework</label>
                        <input type="number" id="homework" name="homework" class="form-control" step="0.01" value="<?= $gradeReport['homework']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="error" class="form-label">Er</label>
                        <input type="number" id="error" name="error" class="form-control" step="0.01" value="<?= $gradeReport['error']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="evaluation" class="form-label">Ev</label>
                        <input type="number" id="evaluation" name="evaluation" class="form-control" step="0.01" value="<?= $gradeReport['evaluation']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="discussion_solution" class="form-label">D/S</label>
                        <input type="number" id="discussion_solution" name="discussion_solution" class="form-control" step="0.01" value="<?= $gradeReport['discussion_solution']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="additional_hours" class="form-label">A/H</label>
                        <input type="number" id="additional_hours" name="additional_hours" class="form-control" step="0.01" value="<?= $gradeReport['additional_hours']; ?>">
                    </div>
                </div>
            </div>

            <!-- Remarks Section -->
            <div class="form-group">
                <label for="remarks" class="form-label">Remarks</label>
                <input type="text" id="remarks" name="remarks" class="form-control" value="<?= $gradeReport['remarks']; ?>">
            </div>

            <!-- Buttons -->
            <div class="btn-container">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="manage_grade_report.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


</main>
<?php require_once './partials/footer.php'; ?>
