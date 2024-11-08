<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';
ob_start(); // Start output buffering
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
    echo "<script>window.location.href='manage_announcements.php';</script>";
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
    echo "<script>window.location.href='manage_announcements.php';</script>";
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

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notices</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        h2 {
            color: #2c3e50;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            margin-top: 50px;
        }

        .table {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #1abc9c;
            color: #ffffff;
        }

        .table thead th {
            padding: 15px;
            text-align: center;
        }

        .table tbody tr {
            text-align: center;
        }

        .btn-warning, .btn-danger {
            font-size: 0.9rem;
        }

        /* Edit Modal */
        .modal-content {
            border-radius: 8px;
            padding: 20px;
        }

        .modal-header, .modal-footer {
            border: none;
        }

        .modal-header .modal-title {
            color: #2c3e50;
            font-weight: 600;
        }

        .btn-primary, .btn-secondary {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📢 Manage Notices</h2>

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
                            <td><?php echo htmlspecialchars($notice['title']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($notice['content'])); ?></td>
                            <td><?php echo htmlspecialchars($notice['semester']); ?></td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
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
                        <td colspan="4" class="text-center">No notices available</td>
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
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var title = button.getAttribute('data-title');
            var content = button.getAttribute('data-content');
            var semester = button.getAttribute('data-semester');

            var modalBodyInputTitle = editModal.querySelector('#title');
            var modalBodyInputContent = editModal.querySelector('#content');
            var modalBodyInputSemester = editModal.querySelector('#semester');
            var modalBodyInputId = editModal.querySelector('#noticeId');

            modalBodyInputTitle.value = title;
            modalBodyInputContent.value = content;
            modalBodyInputSemester.value = semester;
            modalBodyInputId.value = id;
        });
    </script>
</body>
</html>
<?php require_once 'partials/footer.php' ?>
