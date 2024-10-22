<?php
session_start();

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Redirect if the user is not logged in
if (!isLoggedIn()) {
    header("Location: login.php"); 
    exit;
}
?>
