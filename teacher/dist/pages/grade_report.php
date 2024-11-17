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

// Define all semesters
$semesters = ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'];

// Initialize variables
$subjects = [];
$students = [];

// Fetch subjects if semester is selected
if (isset($_POST['semester'])) {
    $semester = $_POST['semester'];
    $subjects = $conn->query("SELECT * FROM subjects WHERE semester = '$semester'");
}

// Fetch students if both semester and subject are selected
if (isset($_POST['subject_id']) && isset($_POST['semester'])) {
    $subject_id = $_POST['subject_id'];
    $semester = $_POST['semester'];
    $students = $conn->query("SELECT * FROM users WHERE semester = '$semester' AND user_type = 'student'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Report - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to left, #f6fcfb, #f9fcff );
            color: #333;
        }

        .container {
            max-width: 900px;
            margin-top: 2rem;
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
        }

        h2 {
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        /* Form Controls */
        .form-select, .form-control {
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
            transition: all 0.3s ease;
        }

        .form-select:focus, .form-control:focus {
            border-color: #4fa3f7;
            box-shadow: 0 0 5px rgba(79, 163, 247, 0.5);
        }

        /* Button Styling */
        .btn-primary, .btn-success {
            background: linear-gradient(135deg, #4fa3f7, #3285e0);
            border: none;
            padding: 12px 20px;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover, .btn-success:hover {
            background: linear-gradient(135deg, #3285e0, #4fa3f7);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f4f7f9;
            color: #4fa3f7;
            border-radius: 8px;
            padding: 10px 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background: #e0f1ff;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background: #fff;
            color: #333;
        }

        th {
            background: linear-gradient(135deg, #ffebcc, #ffebcc);
            
            font-weight: 600;
        }

        td input {
            width: 70px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        td input:focus {
            border-color: #61c15b;
            box-shadow: 0 0 5px rgba(97, 193, 91, 0.5);
        }

        /* Grid Layout for Form */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-grid .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            color: #555;
        }

        /* Hover Effects */
        td input:hover {
            background-color: #f1f3f5;
        }

        /* Custom Scroll for Tables */
        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            table, .form-grid {
                grid-template-columns: 1fr;
            }

            .btn-container {
                flex-direction: column;
            }
        }
    </style>
    <script>
        function calculateTotals(studentId) {
            // Theory Component (TC) calculation
            const midExam = parseFloat(document.getElementById(`mid_exam_${studentId}`).value) || 0;
            const classTest = parseFloat(document.getElementById(`class_test_${studentId}`).value) || 0;
            const quizTest = parseFloat(document.getElementById(`quiz_test_${studentId}`).value) || 0;
            const performanceAssessment = parseFloat(document.getElementById(`performance_assessment_${studentId}`).value) || 0;
            const assignmentHomework = parseFloat(document.getElementById(`assignment_homework_${studentId}`).value) || 0;
            const totalTC = midExam + classTest + quizTest + performanceAssessment + assignmentHomework;
            document.getElementById(`total_tc_${studentId}`).value = totalTC.toFixed(2);

            // Practical Component (PC) calculation
            const experiment = parseFloat(document.getElementById(`experiment_${studentId}`).value) || 0;
            const homework = parseFloat(document.getElementById(`homework_${studentId}`).value) || 0;
            const error = parseFloat(document.getElementById(`error_${studentId}`).value) || 0;
            const evaluation = parseFloat(document.getElementById(`evaluation_${studentId}`).value) || 0;
            const discussionSolution = parseFloat(document.getElementById(`discussion_solution_${studentId}`).value) || 0;
            const additionalHours = parseFloat(document.getElementById(`additional_hours_${studentId}`).value) || 0;
            const totalPC = experiment + homework + error + evaluation + discussionSolution + additionalHours;
            document.getElementById(`total_pc_${studentId}`).value = totalPC.toFixed(2);
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Grade Report</h2>

    <!-- Form to select semester and subject -->
    <form method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label for="semester" class="form-label">Select Semester</label>
                <select id="semester" name="semester" class="form-select" required>
                    <option value="">Select Semester</option>
                    <?php foreach ($semesters as $sem): ?>
                        <option value="<?= $sem; ?>" <?= (isset($semester) && $semester === $sem) ? 'selected' : ''; ?>><?= $sem; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (!empty($subjects) && $subjects->num_rows > 0): ?>
                <div class="form-group">
                    <label for="subject_id" class="form-label">Select Subject</label>
                    <select id="subject_id" name="subject_id" class="form-select" required>
                        <option value="">Select Subject</option>
                        <?php while ($subject = $subjects->fetch_assoc()): ?>
                            <option value="<?= $subject['id']; ?>"><?= $subject['subject_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Load Students</button>
        </div>
    </form>

    <!-- Grade Entry Table -->
    <?php if ($students && isset($subject_id) && isset($semester)): ?>
        <form action="submit_grade_report.php" method="POST">
            <input type="hidden" name="subject_id" value="<?= $subject_id; ?>">
            <input type="hidden" name="semester" value="<?= $semester; ?>">

            <div class="table-container">
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th rowspan="2">SL</th>
                            <th rowspan="2">Name of Examinee</th>
                            <th rowspan="2">College ID</th>
                            <th rowspan="2">Att.</th>
                            <th colspan="6">TC</th>
                            <th colspan="7">PC</th>
                            <th rowspan="2">Remarks</th>
                        </tr>
                        <tr>
                            <th>MID</th>
                            <th>CT</th>
                            <th>QT</th>
                            <th>P/A</th>
                            <th>AH</th>
                            <th>Total</th>
                            <th>Exp.</th>
                            <th>HW</th>
                            <th>ER</th>
                            <th>EV</th>
                            <th>D/S</th>
                            <th>AH</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php while ($student = $students->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $student['name']; ?></td>
                                <td><?= $student['id']; ?></td>
                                <td><input type="number" name="attendance[<?= $student['id']; ?>]" step="0.01" min="0" max="100"></td>
                                <td><input type="number" id="mid_exam_<?= $student['id']; ?>" name="mid_exam[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="class_test_<?= $student['id']; ?>" name="class_test[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="quiz_test_<?= $student['id']; ?>" name="quiz_test[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="performance_assessment_<?= $student['id']; ?>" name="performance_assessment[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="assignment_homework_<?= $student['id']; ?>" name="assignment_homework[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="total_tc_<?= $student['id']; ?>" name="total_tc[<?= $student['id']; ?>]" step="0.01" readonly></td>
                                <td><input type="number" id="experiment_<?= $student['id']; ?>" name="experiment[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="homework_<?= $student['id']; ?>" name="homework[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="error_<?= $student['id']; ?>" name="error[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="evaluation_<?= $student['id']; ?>" name="evaluation[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="discussion_solution_<?= $student['id']; ?>" name="discussion_solution[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="additional_hours_<?= $student['id']; ?>" name="additional_hours[<?= $student['id']; ?>]" step="0.01" oninput="calculateTotals(<?= $student['id']; ?>)"></td>
                                <td><input type="number" id="total_pc_<?= $student['id']; ?>" name="total_pc[<?= $student['id']; ?>]" step="0.01" readonly></td>
                                <td><input type="text" name="remarks[<?= $student['id']; ?>]"></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success">Submit Grade Report</button>
        </form>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</main>
<?php require_once 'partials/footer.php' ?>
