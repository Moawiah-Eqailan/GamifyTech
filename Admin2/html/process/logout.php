<?php
session_start();  // Start the session

// Destroy all session variables
$_SESSION = array();

// Destroy the session itself
session_destroy();

// Redirect to the login page or homepage after logging out
header("Location: login.php");
exit();
?>
