<?php
session_start();
$conn= new mysqli('localhost','root','','sipi_cst_portal');
// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Get data from the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $semester = $_POST['semester'];
    $subject_id = $_POST['subject_id'];

    // Loop through all the student grades
    foreach ($_POST['attendance'] as $student_id => $attendance) {
        // Get all the fields for each student
        echo "<script>alert('The grade has been submitted');</script>";
        $mid_exam = $_POST['mid_exam'][$student_id] ?? null;
        $class_test = $_POST['class_test'][$student_id] ?? null;
        $quiz_test = $_POST['quiz_test'][$student_id] ?? null;
        $performance_assessment = $_POST['performance_assessment'][$student_id] ?? null;
        $assignment_homework = $_POST['assignment_homework'][$student_id] ?? null;
        $total_tc = $_POST['total_tc'][$student_id] ?? null;
        $experiment = $_POST['experiment'][$student_id] ?? null;
        $homework = $_POST['homework'][$student_id] ?? null;
        $error = $_POST['error'][$student_id] ?? null;
        $evaluation = $_POST['evaluation'][$student_id] ?? null;
        $discussion_solution = $_POST['discussion_solution'][$student_id] ?? null;
        $additional_hours = $_POST['additional_hours'][$student_id] ?? null;
        $total_pc = $_POST['total_pc'][$student_id] ?? null;
        $remarks = $_POST['remarks'][$student_id] ?? null;

        // Insert grade data into the grade_reports table
        $stmt = $conn->prepare("INSERT INTO grade_reports (student_id, subject_id, semester, attendance, mid_exam, class_test, quiz_test, performance_assessment, assignment_homework, total_tc, experiment, homework, error, evaluation, discussion_solution, additional_hours, total_pc, remarks)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("iissddddddddddddds",
            $student_id,
            $subject_id,
            $semester,
            $attendance,
            $mid_exam,
            $class_test,
            $quiz_test,
            $performance_assessment,
            $assignment_homework,
            $total_tc,
            $experiment,
            $homework,
            $error,
            $evaluation,
            $discussion_solution,
            $additional_hours,
            $total_pc,
            $remarks
        );

        // Execute the query
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
    }

    // Redirect after submission to avoid form resubmission
    header('Location: grade_report.php?semester=' . $semester . '&subject_id=' . $subject_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Grade Report - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Grade Report Submission</h2>
    <p>Your grade report has been successfully submitted.</p>
    <a href="grade_report.php?semester=<?= $semester; ?>&subject_id=<?= $subject_id; ?>" class="btn btn-primary">Go Back to Grade Report</a>
</div>
</body>
</html>
