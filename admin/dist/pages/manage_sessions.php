<?php
session_start();
require_once 'partials/header.php';
require_once 'partials/navbar.php';
require_once 'partials/sidebar.php';

// Check if the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    echo "<script>alert('You do not have permission to access this page.'); window.location.href = 'index.php';</script>";
    exit();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $session_id = $_GET['delete'];
    $delete_query = $conn->prepare("DELETE FROM sessions WHERE id = ?");
    $delete_query->bind_param('i', $session_id);

    if ($delete_query->execute()) {
        $success_message = "Session deleted successfully!";
    } else {
        $error_message = "Error deleting session: " . $conn->error;
    }
    $delete_query->close();
}

// Handle editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_session_id'])) {
    $edit_session_id = $_POST['edit_session_id'];
    $new_session_value = $_POST['edit_session'];

    $edit_query = $conn->prepare("UPDATE sessions SET session = ? WHERE id = ?");
    $edit_query->bind_param('si', $new_session_value, $edit_session_id);

    if ($edit_query->execute()) {
        $success_message = "Session updated successfully!";
    } else {
        $error_message = "Error updating session: " . $conn->error;
    }
    $edit_query->close();
}

// Fetch all sessions
$sessions_query = $conn->prepare("SELECT * FROM sessions ORDER BY id DESC");
$sessions_query->execute();
$sessions_result = $sessions_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sessions - SIPI CST Portal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Manage Academic Sessions</h2>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <table class="table table-hover table-striped table-bordered mt-4">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Session</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($sessions_result->num_rows > 0): ?>
            <?php while ($session = $sessions_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $session['id']; ?></td>
                    <td><?php echo htmlspecialchars($session['session']); ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal-<?php echo $session['id']; ?>">
                            Edit
                        </button>
                        <!-- Delete Button -->
                        <a href="?delete=<?php echo $session['id']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this session?');">Delete</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal-<?php echo $session['id']; ?>" tabindex="-1"
                     aria-labelledby="editModalLabel-<?php echo $session['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-<?php echo $session['id']; ?>">Edit Session</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post" action="">
                                <div class="modal-body">
                                    <input type="hidden" name="edit_session_id" value="<?php echo $session['id']; ?>">
                                    <div class="mb-3">
                                        <label for="edit_session" class="form-label">Session</label>
                                        <input type="text" class="form-control" id="edit_session"
                                               name="edit_session" value="<?php echo htmlspecialchars($session['session']); ?>"
                                               required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center text-warning">No sessions found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$sessions_query->close();
$conn->close();
?>
