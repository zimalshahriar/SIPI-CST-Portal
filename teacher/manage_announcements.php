<?php
session_start();
require_once '../db/database.php'; // Ensure you have the correct path to your database connection file

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $semester = trim($_POST['semester']);

    if (!empty($title) && !empty($content) && !empty($semester)) {
        $sql = "UPDATE notices SET title=?, content=?, semester=? WHERE id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $title, $content, $semester, $id);
            $stmt->execute();
            $_SESSION['message'] = "Notice updated successfully!";
            $stmt->close();
        }
    } else {
        $_SESSION['message'] = "All fields are required!";
    }
    header("Location: manage_announcements.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM notices WHERE id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $_SESSION['message'] = "Notice deleted successfully!";
        $stmt->close();
    }
    header("Location: manage_announcements.php");
    exit;
}

// Fetch Notices
$sql = "SELECT * FROM notices ORDER BY created_at DESC";
$result = $conn->query($sql);

// Fetch a specific notice for editing
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM notices WHERE id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $edit = $result->fetch_assoc();
        $stmt->close();
    }
}

// Fetch Semesters from Database
$sql_semesters = "SELECT DISTINCT semester FROM notices"; // Adjust this query based on your semester logic
$semester_result = $conn->query($sql_semesters);
$semesters = [];
if ($semester_result->num_rows > 0) {
    while ($row = $semester_result->fetch_assoc()) {
        $semesters[] = $row['semester'];
    }
} else {
    $_SESSION['message'] = "No semesters found!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notices</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Notices</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <script>
                alert("<?php echo $_SESSION['message']; unset($_SESSION['message']); ?>");
            </script>
        <?php endif; ?>

        <!-- Notices Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($notice = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $notice['id']; ?></td>
                            <td><?php echo htmlspecialchars($notice['title']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($notice['content'])); ?></td>
                            <td><?php echo htmlspecialchars($notice['semester']); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                                    data-id="<?php echo $notice['id']; ?>" 
                                    data-title="<?php echo htmlspecialchars($notice['title']); ?>" 
                                    data-content="<?php echo htmlspecialchars($notice['content']); ?>" 
                                    data-semester="<?php echo htmlspecialchars($notice['semester']); ?>">Edit</button>
                                <a href="manage_announcements.php?delete=<?php echo $notice['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No notices available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="manage_announcements.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Notice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="noticeId">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-select" id="semester" name="semester" required>
                                <option value="" disabled selected>Select a semester</option>
                                <?php foreach ($semesters as $semester): ?>
                                    <option value="<?php echo htmlspecialchars($semester); ?>">
                                        <?php echo htmlspecialchars($semester); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle modal data
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var id = button.getAttribute('data-id');
            var title = button.getAttribute('data-title');
            var content = button.getAttribute('data-content');
            var semester = button.getAttribute('data-semester');

            // Update the modal's content
            var modalTitle = editModal.querySelector('.modal-title');
            var modalBodyInputTitle = editModal.querySelector('#title');
            var modalBodyInputContent = editModal.querySelector('#content');
            var modalBodyInputSemester = editModal.querySelector('#semester');
            var modalBodyInputId = editModal.querySelector('#noticeId');

            modalTitle.textContent = 'Edit Notice';
            modalBodyInputTitle.value = title;
            modalBodyInputContent.value = content;
            modalBodyInputSemester.value = semester; // Set the current semester value
            modalBodyInputId.value = id;
        });
    </script>
</body>
</html>
