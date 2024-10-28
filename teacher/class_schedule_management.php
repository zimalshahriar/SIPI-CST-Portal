<?php
session_start();
include '../db/database.php';

// Check if the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Fetch all class schedules
$class_schedules = $conn->query("SELECT cs.id, cs.day, cs.start_time, cs.end_time, cs.semester, s.subject_name, cs.teacher_name 
FROM class_schedule cs
JOIN subjects s ON cs.subject_id = s.id
ORDER BY cs.day, cs.start_time");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Manage Class Schedule - SIPI CST Portal</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Class Schedule</h2>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Teacher Name</th>
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
                    <td><?= htmlspecialchars($row['subject_name']); ?></td>
                    <td><?= htmlspecialchars($row['teacher_name']); ?></td>
                    <td><?= htmlspecialchars($row['day']); ?></td>
                    <td><?= htmlspecialchars($row['start_time']); ?></td>
                    <td><?= htmlspecialchars($row['end_time']); ?></td>
                    <td><?= htmlspecialchars($row['semester']); ?></td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">Edit</a>
                        <a href="delete_class_schedule.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this schedule?');">Delete</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Class Schedule</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="update_class_schedule.php">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="subject_id" class="form-label">Subject</label>
                                        <select class="form-select" id="subject_id" name="subject_id" required>
                                            <option value="<?= $row['subject_id']; ?>"><?= htmlspecialchars($row['subject_name']); ?></option>
                                            <?php
                                            $subjects = $conn->query("SELECT id, subject_name FROM subjects");
                                            while ($subject = $subjects->fetch_assoc()): ?>
                                                <option value="<?= $subject['id']; ?>"><?= htmlspecialchars($subject['subject_name']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="day" class="form-label">Day</label>
                                        <select class="form-select" id="day" name="day" required>
                                            <option value="<?= $row['day']; ?>"><?= htmlspecialchars($row['day']); ?></option>
                                            <option value="Saturday">Saturday</option>
                                            <option value="Sunday">Sunday</option>
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="start_time" class="form-label">Start Time</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?= $row['start_time']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_time" class="form-label">End Time</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?= $row['end_time']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select class="form-select" id="semester" name="semester" required>
                                            <option value="<?= $row['semester']; ?>"><?= htmlspecialchars($row['semester']); ?></option>
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

                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
