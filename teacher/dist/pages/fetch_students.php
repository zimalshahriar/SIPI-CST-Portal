<?php
$conn = new mysqli('localhost', 'root', '', 'sipi_cst_portal');

if (isset($_POST['subject_id'])) {
    $subject_id = $_POST['subject_id'];

    // Fetch semester for the selected subject
    $subject_query = $conn->prepare("SELECT semester FROM subjects WHERE id = ?");
    $subject_query->bind_param('i', $subject_id);
    $subject_query->execute();
    $result = $subject_query->get_result();
    $subject = $result->fetch_assoc();
    $semester = $subject['semester'];

    // Fetch students in the same semester
    $students = $conn->query("SELECT id, name FROM users WHERE semester = '$semester' AND user_type = 'student' ORDER BY name");

    if ($students->num_rows > 0): ?>
        <form method="POST" action="attendance.php">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?= $student['id']; ?></td>
                            <td><?= $student['name']; ?></td>
                            <td>
                                <input type="hidden" name="student_id[]" value="<?= $student['id']; ?>">
                                <select name="status[]" class="form-select">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                </select>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Submit Attendance</button>
        </form>
    <?php else: ?>
        <p>No students found for this semester.</p>
    <?php endif;
}
?>
