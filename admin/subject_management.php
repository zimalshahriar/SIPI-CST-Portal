<?php
session_start();
include '../db/database.php';

// Check if user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Handle adding a new subject
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subject'])) {
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $semester = $_POST['semester'];

    $stmt = $conn->prepare("INSERT INTO subjects (subject_name, subject_code, semester) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $subject_name, $subject_code, $semester);
    $stmt->execute();
    $stmt->close();
    header('Location: subject_management.php');
    exit;
}

// Handle editing a subject
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_subject'])) {
    $subject_id = $_POST['subject_id'];
    $subject_name = $_POST['edit_subject_name'];
    $subject_code = $_POST['edit_subject_code'];
    $semester = $_POST['edit_semester'];

    $stmt = $conn->prepare("UPDATE subjects SET subject_name = ?, subject_code = ?, semester = ? WHERE id = ?");
    $stmt->bind_param('sssi', $subject_name, $subject_code, $semester, $subject_id);
    $stmt->execute();
    $stmt->close();
    header('Location: subject_management.php');
    exit;
}

// Fetch all subjects
$subjects = $conn->query("SELECT * FROM subjects ORDER BY semester");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>Manage Subjects - SIPI CST Portal</title>
</head>
<body>
<div class="container mt-5">
    <h2>Manage Subjects</h2>
    <form method="POST">
        <input type="text" name="subject_name" placeholder="Subject Name" required>
        <input type="text" name="subject_code" placeholder="Subject Code" required>
        <select name="semester" required>
            <option value="">Select Semester</option>
            <option value="1st">1st</option>
            <option value="2nd">2nd</option>
            <option value="3rd">3rd</option>
            <option value="4th">4th</option>
            <option value="5th">5th</option>
            <option value="6th">6th</option>
            <option value="7th">7th</option>
            <option value="8th">8th</option>
        </select>
        <button type="submit" name="add_subject" class="btn btn-success">Add Subject</button>
    </form>
    
    <table class="table mt-3">
        <thead><tr><th>Subject Name</th><th>Code</th><th>Semester</th><th>Actions</th></tr></thead>
        <tbody>
            <?php while ($row = $subjects->fetch_assoc()): ?>
            <tr>
                <td><?= $row['subject_name']; ?></td>
                <td><?= $row['subject_code']; ?></td>
                <td><?= $row['semester']; ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">Edit</button>
                    <a href="delete_subject.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?= $row['id']; ?>">Edit Subject</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="subject_id" value="<?= $row['id']; ?>">
                                <div class="mb-3">
                                    <label for="edit_subject_name" class="form-label">Subject Name</label>
                                    <input type="text" class="form-control" id="edit_subject_name" name="edit_subject_name" value="<?= $row['subject_name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_subject_code" class="form-label">Subject Code</label>
                                    <input type="text" class="form-control" id="edit_subject_code" name="edit_subject_code" value="<?= $row['subject_code']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_semester" class="form-label">Semester</label>
                                    <select class="form-select" id="edit_semester" name="edit_semester" required>
                                        <option value="1st" <?= $row['semester'] == '1st' ? 'selected' : ''; ?>>1st</option>
                                        <option value="2nd" <?= $row['semester'] == '2nd' ? 'selected' : ''; ?>>2nd</option>
                                        <option value="3rd" <?= $row['semester'] == '3rd' ? 'selected' : ''; ?>>3rd</option>
                                        <option value="4th" <?= $row['semester'] == '4th' ? 'selected' : ''; ?>>4th</option>
                                        <option value="5th" <?= $row['semester'] == '5th' ? 'selected' : ''; ?>>5th</option>
                                        <option value="6th" <?= $row['semester'] == '6th' ? 'selected' : ''; ?>>6th</option>
                                        <option value="7th" <?= $row['semester'] == '7th' ? 'selected' : ''; ?>>7th</option>
                                        <option value="8th" <?= $row['semester'] == '8th' ? 'selected' : ''; ?>>8th</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_subject" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>