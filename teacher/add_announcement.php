<?php
session_start();
include '../db/database.php';

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Define all semesters
$semesters = ['All Semester', '1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'];

// Initialize variables
$announcementType = '';
$semester = '';
$title = '';
$announcementText = '';
$file_path = '';
$alertMessage = '';
$alertType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $semester = $_POST['semester'];
    $announcementType = $_POST['announcement_type'];
    
    // Capture the title based on the announcement type
    $title = ($announcementType == 'text') ? $_POST['text_title'] : $_POST['pdf_title'];

    if ($announcementType == 'text') {
        $announcementText = $_POST['announcement_text'];
        $stmt = $conn->prepare("INSERT INTO announcements (title, content, semester, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $title, $announcementText, $semester);
    } else if ($announcementType == 'pdf') {
        if (isset($_FILES['announcement_pdf']) && $_FILES['announcement_pdf']['error'] == 0) {
            $file_name = $_FILES['announcement_pdf']['name'];
            $file_tmp = $_FILES['announcement_pdf']['tmp_name'];
            $file_path = '../uploads/' . uniqid() . '-' . $file_name;
            if (move_uploaded_file($file_tmp, $file_path)) {
                $stmt = $conn->prepare("INSERT INTO announcements (title, file_path, semester, created_at) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("sss", $title, $file_path, $semester);
            } else {
                $alertMessage = "File upload failed.";
                $alertType = "danger";
            }
        } else {
            $alertMessage = "Error uploading PDF.";
            $alertType = "danger";
        }
    }

    if ($stmt->execute()) {
        $alertMessage = "Announcement published successfully!";
        $alertType = "success";
    } else {
        $alertMessage = "Error publishing announcement: " . $stmt->error;
        $alertType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Announcement - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function toggleAnnouncementFields() {
            const announcementType = document.querySelector('input[name="announcement_type"]:checked').value;
            const textFields = document.getElementById('text-fields');
            const pdfFields = document.getElementById('pdf-fields');
            const textTitle = document.getElementById('text-title');
            const pdfTitle = document.getElementById('pdf-title');
            const pdfFile = document.getElementById('announcement_pdf');

            if (announcementType === 'text') {
                textFields.style.display = 'block';
                pdfFields.style.display = 'none';
                textTitle.required = true;
                pdfTitle.required = false;
                pdfFile.required = false;
            } else if (announcementType === 'pdf') {
                textFields.style.display = 'none';
                pdfFields.style.display = 'block';
                textTitle.required = false;
                pdfTitle.required = true;
                pdfFile.required = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleAnnouncementFields();
        });
    </script>
</head>
<body>
<div class="container mt-5">
    <h2>Add Announcement</h2>

    <!-- Alert message -->
    <?php if (!empty($alertMessage)): ?>
        <div class="alert alert-<?= $alertType; ?> alert-dismissible fade show" role="alert">
            <?= $alertMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="semester" class="form-label">Select Semester</label>
            <select id="semester" name="semester" class="form-select" required>
                <?php foreach ($semesters as $sem): ?>
                    <option value="<?= $sem; ?>" <?= (isset($semester) && $semester === $sem) ? 'selected' : ''; ?>><?= $sem; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Announcement Type</label><br>
            <input type="radio" id="text" name="announcement_type" value="text" onclick="toggleAnnouncementFields()" required <?= $announcementType === 'text' ? 'checked' : ''; ?>> 
            <label for="text">Text</label>

            <input type="radio" id="pdf" name="announcement_type" value="pdf" onclick="toggleAnnouncementFields()" required <?= $announcementType === 'pdf' ? 'checked' : ''; ?>> 
            <label for="pdf">PDF</label>
        </div>

        <div id="text-fields" style="display: none;">
            <div class="mb-3">
                <label for="text-title" class="form-label">Title</label>
                <input type="text" name="text_title" id="text-title" class="form-control">
            </div>
            <div class="mb-3">
                <label for="announcement_text" class="form-label">Announcement</label>
                <textarea name="announcement_text" id="announcement_text" class="form-control" rows="5"></textarea>
            </div>
        </div>

        <div id="pdf-fields" style="display: none;">
            <div class="mb-3">
                <label for="pdf-title" class="form-label">Title</label>
                <input type="text" name="pdf_title" id="pdf-title" class="form-control">
            </div>
            <div class="mb-3">
                <label for="announcement_pdf" class="form-label">Upload PDF</label>
                <input type="file" name="announcement_pdf" id="announcement_pdf" class="form-control" accept="application/pdf">
            </div>
        </div>

        <button type="submit" class="btn btn-success">Publish Announcement</button>
    </form>
</div>
</body>
</html>
