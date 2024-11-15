<?php
session_start();
include 'db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $query->bind_param('s', $user_id);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['photo'] = $user['photo'];
        $_SESSION['semester'] = $user['semester'];
        $_SESSION['id'] = $user['id'];

        // Redirect to the appropriate dashboard
        if ($user['user_type'] === 'student') {
            header('Location: student/view_announcements.php');
        } elseif ($user['user_type'] === 'teacher') {
            header('Location: teacher/index.php');
        } else {
            header('Location: admin/index.php');
        }
    } else {
        // Invalid login credentials
        $error = "Invalid user ID or password";
        echo "<script>alert('$error');</script>";
    }
}
// Initialize an error variable for invalid login attempts
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $query->bind_param('s', $user_id);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];  // Assuming $user['email'] is fetched from the database
        $_SESSION['photo'] = $user['photo'];  // Assuming this is for the profile photo
        $_SESSION['semester'] = $user['semester'];

        // Redirect to the appropriate dashboard
        if ($user['user_type'] === 'student') {
            header('Location: student/dist/pages/view_announcements.php');
        } elseif ($user['user_type'] === 'teacher') {
            header('Location: teacher/index.php');
        } else {
            header('Location: admin/index.php');
        }
        exit;
    } else {
        $error = "Invalid user ID or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Login Page</title>
 <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

body {
    background-color: #c9d6ff;
    background: linear-gradient(to right, #e2e2e2, #c9d6ff);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    min-height: 100vh;
    padding: 10px;
}

.container {
    background-color: #fff;
    border-radius: 150px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    overflow: hidden;
    width: 100%;
    max-width: 768px;
    min-height: 480px;
    position: relative;
}

.container p {
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.3px;
    margin: 20px 0;
}

.container span {
    font-size: 12px;
}

.container a {
    color: #333;
    font-size: 13px;
    text-decoration: none;
    margin: 15px 0 10px;
}

.container button {
    background-color:#1f3d7a;
    color: #fff;
    padding: 10px 45px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    cursor: pointer;
}

.container button.hidden {
    background-color: transparent;
    border-color: #fff;
}

.container form {
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 20px;
    height: 100%;
}

.container input {
    background-color: #eee;
    border: none;
    margin: 8px 0;
    padding: 10px 15px;
    font-size: 13px;
    border-radius: 8px;
    width: 100%;
    outline: none;
}

.sign-up, .sign-in {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in {
    left: 0;
    width: 50%;
    z-index: 2;
}

.container.active .sign-in {
    transform: translateX(100%);
}

.sign-up {
    left: 0;
    width: 50%;
    z-index: 1;
    opacity: 0;
}

.container.active .sign-up {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: move 0.6s;
}

@keyframes move {
    0%, 49.99% {
        opacity: 0;
        z-index: 1;
    }
    50%, 100% {
        opacity: 1;
        z-index: 5;
    }
}

.icons {
    margin: 20px 0;
}

.icons a {
    border: 1px solid #ccc;
    border-radius: 20%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 3px;
    width: 40px;
    height: 40px;
}

.toogle-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    border-radius: 150px;
    z-index: 1000;
    transition: all 0.6s ease-in-out;
}

.container.active .toogle-container {
    transform: translateX(-100%);
    border-radius: 150px;
}

.toogle {
    background-color:#1f3d7a;
    height: 100%;
    background: #1f3d7a;
    color: #fff;
    position: relative;
    left: -100%;
    width: 200%;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.container.active .toogle {
    transform: translateX(50%);
}

.toogle-panel {
    position: absolute;
    width: 50%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 0 30px;
    text-align: center;
    top: 0;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.toogle-left {
    transform: translateX(-200%);
}

.container.active .toogle-left {
    transform: translateX(0);
}

.toogle-right {
    right: 0;
    transform: translateX(0);
}

.container.active .toogle-right {
    transform: translateX(200%);
}

/* Tablets */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
        border-radius: 10px;
    }
}

/* Small screens (mobile) */
@media (max-width: 480px) {
    .container {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
    }
    .icons a {
        width: 30px;
        height: 30px;
    }
}

 </style>
</head>
<body>
    <div class="container" id="container">
        <div class="sign-in">
            <form method="POST" action="login.php">
                <h1>Sign In</h1>
                <div class="icons">
                    <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                </div>
                <span>or use user id & password</span>
                <input type="text" name="user_id" placeholder="User ID" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Login</button>
                <?php if (!empty($error)): ?>
                    <p style="color: red;"><?= $error ?></p>
                <?php endif; ?>
            </form>
        </div>
        <div class="toogle-container">
            <div class="toogle">
                <div class="toogle-panel toogle-left">
                    <h1>Hello, User!</h1>
                    <p>© 2024 Shyamoli Ideal Polytechnic Institute - CST Department</p>
                    <button class="hidden" id="login">Login</button>
                </div>
                <div class="toogle-panel toogle-right">
                <img style="width: 165px;"  src="image/sipi logo05.png" alt="">
                    <h2 style="margin-top: 10px;">Welcome To SIPI CST Portal!</h2>
                    <p style="margin-bottom: 65px;">Shyamoli Ideal Polytechnic Institute - Computer Science and Technology Department.</p>
                    <!-- <button class="hidden" id="register">Login</button> -->
                </div>
            </div>
        </div>
    </div>
    <script>
        const container = document.getElementById("container");
        const loginBtn = document.getElementById("login");
        loginBtn.addEventListener("click", () => {
            container.classList.remove("active");
        });
    </script>
</body>
</html>
