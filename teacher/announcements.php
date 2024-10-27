<?php
session_start();
include '../db/database.php';

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post New Notice</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }

        h2 {
            color: #2980b9;
            font-weight: 600;
            margin-bottom: 40px;
            text-align: center;
            animation: fadeIn 1.5s;
        }

        .container {
            max-width: 700px;
            margin-top: 50px;
        }

        .form-control, .form-select {
            background-color: #ecf0f1;
            border: none;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: background-color 0.3s;
        }

        .form-control:focus, .form-select:focus {
            background-color: #e0e7ec;
            outline: none;
            box-shadow: none;
        }

        button {
            background-color: #3498db;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        .card {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 12px;
            background: linear-gradient(145deg, #ffffff, #ecf0f1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
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
                <button type="submit" class="btn btn-primary w-100">Post Notice</button>
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
