<?php
session_start();
require_once '../config/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Check if user is a teacher
    $sql_teacher = "SELECT * FROM teachers WHERE email = ?";
    if ($stmt = $conn->prepare($sql_teacher)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $teacher = $result->fetch_assoc();
            if (password_verify($password, $teacher['password'])) {
                $_SESSION['user_id'] = $teacher['id'];
                $_SESSION['user_type'] = 'teacher';
                header("Location: ../dashboard/index.php");
                exit;
            }
        }
        $stmt->close();
    }

    // Check if user is a student
    $sql_student = "SELECT * FROM students WHERE email = ?";
    if ($stmt = $conn->prepare($sql_student)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $student = $result->fetch_assoc();
            if (password_verify($password, $student['password'])) {
                $_SESSION['user_id'] = $student['id'];
                $_SESSION['user_type'] = 'student';
                header("Location: ../dashboard/index.php");
                exit;
            }
        }
        $stmt->close();
    }

    $_SESSION['error'] = "Invalid email or password";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPI CST Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #E74C3C;
            --accent-color: #3498DB;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 400px;
            max-width: 90%;
            backdrop-filter: blur(10px);
        }
        
        .login-header {
            background: var(--primary-color);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .login-header img {
            width: 80px;
            margin-bottom: 15px;
        }
        
        .login-form {
            padding: 40px 30px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #eee;
            padding: 12px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-login {
            background: var(--accent-color);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .login-footer {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .floating-shapes div {
            position: absolute;
            pointer-events: none;
            animation: float 15s infinite linear;
            opacity: 0.1;
        }
        
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(100px, 100px) rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <?php for($i = 0; $i < 5; $i++): ?>
            <div class="shape" style="
                left: <?= rand(0, 100) ?>%;
                top: <?= rand(0, 100) ?>%;
                width: <?= rand(50, 150) ?>px;
                height: <?= rand(50, 150) ?>px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: <?= rand(0, 50) ?>%;
                animation-delay: <?= $i * 0.5 ?>s;
            "></div>
        <?php endfor; ?>
    </div>

    <div class="login-container animate__animated animate__fadeIn">
        <div class="login-header">
            <img src="../assets/images/logo.jpeg" alt="University Logo" class="animate__animated animate__bounceIn">
            <h4 class="mb-0">SIPI CST Portal</h4>
        </div>
        
        <div class="login-form">
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger animate__animated animate__shake">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="loginForm">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    <label for="email">Email address</label>
                </div>
                
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-login btn-primary btn-lg">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
        
        <div class="login-footer">
            <p class="mb-0">© 2024 SIPI CST Portal. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all fields');
                return;
            }
            
            // Add loading state to button
            const button = this.querySelector('button[type="submit"]');
            button.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Signing in...
            `;
            button.disabled = true;
        });
    </script>
</body>
</html>