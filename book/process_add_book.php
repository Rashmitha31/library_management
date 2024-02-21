<?php
require_once("config.php");
$con = new mysqli("localhost:3008", "root", "chat", "Book");

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Retrieve form data
$title = $_POST["title"];
$author = $_POST["author"];
$subject = $_POST["subject"];
$publish_date = $_POST["publish_date"];
$Books_Available=$_POST["Books_Available"];

// Validate form data (add more validation as needed)
if (empty($title) || empty($author) || empty($subject) || empty($publish_date) || empty($Books_Available) ) {
    // Handle validation error, e.g., redirect back to the form with an error message
    header("Location: add_book.php?error=validation");
    exit;
}

// Check for duplicates
$sql_check_duplicates = "SELECT * FROM library WHERE title = '$title' AND author = '$author'";
$result = $con->query($sql_check_duplicates);

if ($result->num_rows > 0) {
    // Duplicate found, handle accordingly (e.g., redirect back to the form with an error message)
    header("Location: add_book.php?error=duplicate");
    exit;
}

// No duplicates found, insert the new record
$sql_insert_book = "INSERT INTO library (title, author, subject, publish_date,Available) VALUES ('$title', '$author', '$subject', '$publish_date','$Books_Available')";

if ($con->query($sql_insert_book) === TRUE) {
    // Record inserted successfully, redirect to the dashboard or another page
    header("Location: add_book.php");
    exit;
} else {
    // Handle database insertion error (e.g., redirect back to the form with an error message)
    header("Location: add_book.php?error=database");
    exit;
}

// Close the database connection
$con->close();
?>
