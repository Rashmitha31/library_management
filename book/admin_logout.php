<?php
session_start(); // Start the session if not started already

// Perform logout actions, such as destroying sessions or clearing cookies

session_destroy(); // Destroy the session

// Redirect to login_choice.php after logout
header("Location: login_choice.php");
exit();
?>