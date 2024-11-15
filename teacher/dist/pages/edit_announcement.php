<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Get announcement ID from URL
$announcementId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$announcement = $conn->query("SELECT * FROM announcements WHERE id = $announcementId")->fetch_assoc();

// Redirect if announcement not found
if (!$announcement) {
    header('Location: manage_announcements.php');
    exit;
}

// Initialize variables
$title = $announcement['title'];
$semester = $announcement['semester'];
$announcementType = isset($announcement['file_path']) ? 'pdf' : 'text';
$content = $announcement['content'] ?? '';
$file_path = $announcement['file_path'] ?? '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input values
    $title = trim($_POST['title']);
    $semester = $_POST['semester'];
    $announcementType = $_POST['announcement_type'];
    $content = ''; // Default empty content for pdf

    // Debugging: Check title submission
    var_dump($_POST['title']);  // This will show the title posted from the form

    // If it's a text-based announcement
    if ($announcementType == 'text') {
        $content = trim($_POST['announcement_text']);  // Capture the announcement text content

        // Debugging: Check if the content is posted correctly
        var_dump($content);  // This will show the announcement content posted

        // Prepare the SQL statement for text announcement
        $stmt = $conn->prepare("UPDATE announcements SET title = ?, content = ?, file_path = NULL, semester = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $content, $semester, $announcementId);
    }
    // If it's a PDF-based announcement
    else if ($announcementType == 'pdf') {
        // If a new PDF is uploaded
        if (isset($_FILES['announcement_pdf']) && $_FILES['announcement_pdf']['error'] == 0) {
            $file_name = $_FILES['announcement_pdf']['name'];
            $file_tmp = $_FILES['announcement_pdf']['tmp_name'];
            $file_path = '../uploads/' . $file_name;
            move_uploaded_file($file_tmp, $file_path);

            // Debugging: Check the file path
            var_dump($file_path);  // This will show the uploaded PDF file path

            // Prepare the SQL statement for pdf announcement
            $stmt = $conn->prepare("UPDATE announcements SET title = ?, file_path = ?, content = NULL, semester = ? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $file_path, $semester, $announcementId);
        } else {
            // If no new PDF is uploaded, update only the title and semester
            $stmt = $conn->prepare("UPDATE announcements SET title = ?, content = NULL, semester = ? WHERE id = ?");
            $stmt->bind_param("ssi", $title, $semester, $announcementId);
        }
    }

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['message'] = "Announcement updated successfully!";
        echo "<script>alert('Announcement updated successfully!'); window.location.href = 'manage_announcements.php';</script>";
        exit;
    } else {
        echo "<p>Error updating announcement: " . $stmt->error . "</p>";
    }
}
?>
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement - SIPI CST Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
            background: #f9fcff;
            padding: 5rem;
            border-radius: 0px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            height: 93vh;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-select,
        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .form-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-container .mb-3 {
            grid-column: span 2;
        }

        #text-fields,
        #pdf-fields {
            display: none;
            grid-column: span 2;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            font-weight: bold;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button[type="submit"]:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .form-container {
                grid-template-columns: 1fr;
            }

            .form-container .mb-3 {
                grid-column: span 1;
            }

            button[type="submit"] {
                width: 100%;
            }
        }
    </style>
    <script>
        function toggleAnnouncementFields() {
            var announcementType = document.querySelector('input[name="announcement_type"]:checked').value;
            document.getElementById('text-fields').style.display = (announcementType === 'text') ? 'block' : 'none';
            document.getElementById('pdf-fields').style.display = (announcementType === 'pdf') ? 'block' : 'none';
        }
    </script>
</head>
<body onload="toggleAnnouncementFields()">
<div class="container">
    <h2>Edit Announcement</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-container">
            <div class="mb-3">
                <label for="semester" class="form-label">Select Semester</label>
                <select id="semester" name="semester" class="form-select" required>
                    <option value="All Semester" <?= ($semester == 'All Semester') ? 'selected' : ''; ?>>All Semester</option>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <option value="<?= $i; ?>th" <?= ($semester == "{$i}th") ? 'selected' : ''; ?>><?= $i; ?>th</option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Announcement Type</label><br>
                <input type="radio" id="text" name="announcement_type" value="text" onclick="toggleAnnouncementFields()" <?= ($announcementType === 'text') ? 'checked' : ''; ?>>
                <label for="text">Text</label>

                <input type="radio" id="pdf" name="announcement_type" value="pdf" onclick="toggleAnnouncementFields()" <?= ($announcementType === 'pdf') ? 'checked' : ''; ?>>
                <label for="pdf">PDF</label>
            </div>
        </div>

        <div id="text-fields">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" required value="<?= htmlspecialchars($title); ?>">
            </div>
            <div class="mb-3">
                <label for="announcement_text" class="form-label">Announcement</label>
                <textarea name="announcement_text" id="announcement_text" class="form-control" rows="5"><?= htmlspecialchars($content); ?></textarea>
            </div>
        </div>

        <div id="pdf-fields">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" required value="<?= htmlspecialchars($title); ?>">
            </div>
            <div class="mb-3">
                <label for="announcement_pdf" class="form-label">Upload New PDF</label>
                <input type="file" name="announcement_pdf" id="announcement_pdf" class="form-control" accept="application/pdf">
                <?php if ($file_path): ?>
                    <p>Current PDF: <a href="<?= $file_path; ?>" target="_blank">View PDF</a></p>
                <?php endif; ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Announcement</button>
    </form>
</div>
</body>
</html>

</main>
<?php require_once 'partials/footer.php' ?>
