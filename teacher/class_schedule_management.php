<?php
require_once './partials/header.php';
include '../db/database.php';
require_once './partials/navbar.php';
require_once './partials/sidebar.php';
// Check if the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Fetch all class schedules for display
$class_schedules = $conn->query("SELECT cs.*, s.subject_name FROM class_schedule cs JOIN subjects s ON cs.subject_id = s.id");

// Handle messages for actions
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Class Schedule Management - SIPI CST Portal</title>
    <!-- Include jQuery for modal handling -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Class Schedule Management</h2>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message; ?></div>
    <?php endif; ?>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Subject Name</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Semester</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $class_schedules->fetch_assoc()): ?>
            <tr>
                <td><?= $row['subject_name']; ?></td>
                <td><?= $row['day']; ?></td>
                <td><?= $row['start_time']; ?></td>
                <td><?= $row['end_time']; ?></td>
                <td><?= $row['semester']; ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal" 
                            data-id="<?= $row['id']; ?>" 
                            data-subject-id="<?= $row['subject_id']; ?>" 
                            data-day="<?= $row['day']; ?>" 
                            data-start-time="<?= $row['start_time']; ?>" 
                            data-end-time="<?= $row['end_time']; ?>" 
                            data-semester="<?= $row['semester']; ?>">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id']; ?>">
                        Delete
                    </button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal for updating class schedule -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Class Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="update_class_schedule.php">
                    <input type="hidden" name="id" id="schedule_id">
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select name="subject_id" id="subject_id" class="form-select" required>
                            <option value="">Select Subject</option>
                            <?php
                            $subjects = $conn->query("SELECT * FROM subjects");
                            while ($subject = $subjects->fetch_assoc()): ?>
                                <option value="<?= $subject['id']; ?>"><?= $subject['subject_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="day" class="form-label">Day</label>
                        <input type="text" name="day" id="day" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select name="semester" id="semester" class="form-select" required>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                            <option value="5th">5th</option>
                            <option value="6th">6th</option>
                            <option value="7th">7th</option>
                            <option value="8th">8th</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Schedule</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script to populate modal with data
    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var subjectId = button.data('subject-id');
        var day = button.data('day');
        var startTime = button.data('start-time');
        var endTime = button.data('end-time');
        var semester = button.data('semester');

        // Update the modal's content.
        var modal = $(this);
        modal.find('#schedule_id').val(id);
        modal.find('#subject_id').val(subjectId);
        modal.find('#day').val(day);
        modal.find('#start_time').val(startTime);
        modal.find('#end_time').val(endTime);
        modal.find('#semester').val(semester);
    });

    // Delete confirmation
    $('.delete-btn').click(function() {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this schedule?")) {
            window.location.href = 'delete_class_schedule.php?id=' + id;
        }
    });
</script>

<!-- Bootstrap JS (optional for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>

?>
<?php require_once './partials/footer.php'; ?>
