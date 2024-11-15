<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Announcement - SIPI CST Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleAnnouncementFields() {
            const announcementType = document.querySelector('input[name="announcement_type"]:checked').value;
            const textFields = document.getElementById('text-fields');
            const pdfFields = document.getElementById('pdf-fields');
            const textTitle = document.getElementById('text-title');
            const pdfTitle = document.getElementById('pdf-title');
            const pdfFile = document.getElementById('announcement_pdf');

            if (announcementType === 'text') {
                textFields.style.display = 'grid';
                pdfFields.style.display = 'none';
                textTitle.required = true;
                pdfTitle.required = false;
                pdfFile.required = false;
            } else if (announcementType === 'pdf') {
                textFields.style.display = 'none';
                pdfFields.style.display = 'grid';
                textTitle.required = false;
                pdfTitle.required = true;
                pdfFile.required = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleAnnouncementFields();
        });
    </script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #e6f2ff, #ffffff);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1300px;
            background: linear-gradient(to left, #f6fcfb, #f9fcff );
            border-radius: 0px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 4rem;
        }

        h2 {
            text-align: center;
            color: black;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            text-transform: uppercase;
            font-weight: bold;
        }

        label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            color: #444;
        }

        .form-select,
        .form-control {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.3);
        }

        .form-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        #text-fields,
        #pdf-fields {
            display: none;
            grid-column: span 2;
        }

        .btn-submit {
            display: inline-block;
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background: #007bff;
        }

        .alert {
            margin-top: 1rem;
            font-size: 1rem;
            text-align: center;
            border-radius: 8px;
            padding: 10px;
        }

        @media (max-width: 768px) {
            .form-container {
                grid-template-columns: 1fr;
            }

            #text-fields,
            #pdf-fields {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add Announcement</h2>

    <!-- Alert Message -->
    <?php if (!empty($alertMessage)): ?>
        <div class="alert alert-<?= $alertType; ?> alert-dismissible fade show" role="alert">
            <?= $alertMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" action="" enctype="multipart/form-data" class="form-container">
        <div>
            <label for="semester" class="form-label">Select Semester</label>
            <select id="semester" name="semester" class="form-select" required>
                <?php foreach ($semesters as $sem): ?>
                    <option value="<?= $sem; ?>" <?= (isset($semester) && $semester === $sem) ? 'selected' : ''; ?>><?= $sem; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="form-label">Announcement Type</label>
            <div>
                <input type="radio" id="text" name="announcement_type" value="text" onclick="toggleAnnouncementFields()" required <?= $announcementType === 'text' ? 'checked' : ''; ?>>
                <label for="text">Text</label>

                <input type="radio" id="pdf" name="announcement_type" value="pdf" onclick="toggleAnnouncementFields()" required <?= $announcementType === 'pdf' ? 'checked' : ''; ?>>
                <label for="pdf">PDF</label>
            </div>
        </div>

        <div id="text-fields">
            <div>
                <label for="text-title" class="form-label">Title</label>
                <input type="text" name="text_title" id="text-title" class="form-control">
            </div>
            <div>
                <label for="announcement_text" class="form-label">Announcement</label>
                <textarea name="announcement_text" id="announcement_text" class="form-control" rows="5"></textarea>
            </div>
        </div>

        <div id="pdf-fields">
            <div>
                <label for="pdf-title" class="form-label">Title</label>
                <input type="text" name="pdf_title" id="pdf-title" class="form-control">
            </div>
            <div>
                <label for="announcement_pdf" class="form-label">Upload PDF</label>
                <input type="file" name="announcement_pdf" id="announcement_pdf" class="form-control" accept="application/pdf">
            </div>
        </div>

        <div>
            <button type="submit" class="btn-submit">Publish Announcement</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</main>
<?php require_once 'partials/footer.php'; ?>
