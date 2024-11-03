<?php
require_once './partials/header.php';
include '../db/database.php';
require_once './partials/navbar.php';
require_once './partials/sidebar.php';


// Ensure only teachers can access this page
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: index.php');
    exit;
}

// Fetch distinct semesters from the user table
$semesters = [];
$semester_query = $conn->prepare("SELECT DISTINCT semester FROM users WHERE semester IS NOT NULL");
$semester_query->execute();
$semester_result = $semester_query->get_result();
while ($row = $semester_result->fetch_assoc()) {
    $semesters[] = $row['semester'];
}

// Handle form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $semester = $_POST['semester']; // "All Semester" or a specific semester

    $stmt = $conn->prepare("INSERT INTO notices (title, content, semester, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $title, $content, $semester);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $message = "Notice posted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post New Notice</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin-top: 5%;
        }

        .card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
        }

        h2 {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control, .form-select {
            background-color: #f7f9fc;
            border: 1px solid #d1d9e0;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 12px 15px;
            font-size: 1rem;
            color: #333;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #1abc9c;
            box-shadow: 0 0 8px rgba(26, 188, 156, 0.2);
            outline: none;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #1abc9c, #16a085);
            color: #ffffff;
            font-weight: 600;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            transition: background 0.3s ease;
            display: block;
            width: 100%;
            font-size: 1.1rem;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #16a085, #1abc9c);
        }

        .btn-gradient-primary:focus {
            box-shadow: 0 0 8px rgba(26, 188, 156, 0.4);
        }
    </style>
</head>
    <div class="container">
        <div class="card">
            <h2>📢 Post New Notice</h2>
            <form id="noticeForm" action="" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter notice title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="5" placeholder="Enter notice content" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Target Semester</label>
                    <select class="form-select" id="semester" name="semester" required>
                        <option value="All Semester">All Semester</option>
                        <?php foreach ($semesters as $semester): ?>
                            <option value="<?php echo htmlspecialchars($semester); ?>">
                                <?php echo htmlspecialchars($semester); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-gradient-primary mt-4">Post Notice</button>
            </form>
        </div>
    </div>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Show Toastr notification if there's a message
        <?php if ($message): ?>
            alert("<?php echo htmlspecialchars($message); ?>");
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2000", // Show for 2 seconds
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            <?php if (strpos($message, "Error") !== false): ?>
                toastr.error("<?php echo htmlspecialchars($message); ?>", "Error");
            <?php else: ?>
                toastr.success("<?php echo htmlspecialchars($message); ?>", "Success");
            <?php endif; ?>
        <?php endif; ?>
    </script>

</body>

</html>

<?php require_once './partials/footer.php' ?>
