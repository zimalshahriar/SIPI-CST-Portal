<?php
session_start();

// Unset all of the session variables
$_SESSION = array();
// Destroy the session
session_destroy();

// Redirect to the login page (or any other page)
header("Location: login.php"); 
exit;
?>
