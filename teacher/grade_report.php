<?php
session_start();
include '../db/database.php';

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
<div class="container mt-5">
    <h2>Grade Report</h2>

    <!-- Form to select semester and subject -->
    <form method="POST">
        <div class="mb-3">
            <label for="semester" class="form-label">Select Semester</label>
            <select id="semester" name="semester" class="form-select" required>
                <option value="">Select Semester</option>
                <?php foreach ($semesters as $sem): ?>
                    <option value="<?= $sem; ?>" <?= (isset($semester) && $semester === $sem) ? 'selected' : ''; ?>><?= $sem; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if (!empty($subjects) && $subjects->num_rows > 0): ?>
            <div class="mb-3">
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
    </form>

    <!-- Grade Entry Table -->
    <?php if ($students && isset($subject_id) && isset($semester)): ?>
        <form action="submit_grade_report.php" method="POST">
            <input type="hidden" name="subject_id" value="<?= $subject_id; ?>">
            <input type="hidden" name="semester" value="<?= $semester; ?>">

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

            <button type="submit" class="btn btn-success">Submit Grade Report</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

