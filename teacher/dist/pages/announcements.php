<?php
session_start();
require_once './partials/header.php';
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
<main class="app-main">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post New Notice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #2d3748;
        }

        .container {
            max-width: 100%;
            margin: 0;
            display: grid;
            border-radius: 0px;
            
        }

        .card {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            border: none;
            border-radius: 5px;
            padding: 30px;
        }

        h2 {
            color: #2c5282;
            font-weight: 600;
            font-size: 2rem;
            text-align: center;
            grid-column: span 2;
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .form-label {
            font-weight: 500;
            color: #4a5568;
        }

        .form-control, .form-select {
            background-color: #edf2f7;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 10px 15px;
            font-size: 1rem;
            color: #2d3748;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #2c5282;
            box-shadow: 0 0 8px rgba(44, 82, 130, 0.2);
            outline: none;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #007bff, #007bff);
            color: #ffffff;
            font-weight: 600;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            transition: background 0.3s ease;
            font-size: 1.1rem;
            text-transform: uppercase;
            grid-column: span 2;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #007bff, #007bff);
        }

        .notice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .notice-card {
            padding: 20px;
            border-radius: 8px;
            background: #e6fffa;
            color: #2c7a7b;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
        }

        .notice-card h4 {
            font-size: 1.2rem;
            margin: 0;
        }

        .notice-card p {
            margin: 10px 0 0;
            font-size: 0.9rem;
            color: #4a5568;
        }

        .badge {
            font-size: 0.8rem;
            margin-top: 10px;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>📢 Post a New Notice</h2>
            <form id="noticeForm" action="" method="post">
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter notice title" required>
                </div>
                <div class="form-group">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="4" placeholder="Enter notice content" required></textarea>
                </div>
                <div class="form-group">
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
                <button type="submit" class="btn btn-gradient">Submit Notice</button>
            </form>
        </div>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        <?php if ($message): ?>
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
                "timeOut": "2000",
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

</main>
<?php require_once './partials/footer.php' ?>
