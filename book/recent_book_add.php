<?php
require_once("config.php");
$con = new mysqli("localhost:3008", "root", "chat", "Book");

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Delete book if requested
if(isset($_GET['delete']) && !empty($_GET['delete'])) {
    // Sanitize the input to prevent SQL injection
    $delete_id = intval($_GET['delete']);
    $sql_delete_book = "DELETE FROM library WHERE id = $delete_id";
    if ($con->query($sql_delete_book) === TRUE) {
        // Redirect to current page to refresh the table after deletion
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        header("Location: ".$_SERVER['PHP_SELF']."?page=".$page);
        exit;
    } else {
        echo "Error deleting record: " . $con->error;
    }
}

// Pagination variables
$results_per_page = 5; // Number of results per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

// Calculate the starting point for the results
$start_from = ($page - 1) * $results_per_page;

// Fetch recent books from the database with pagination
$sql_fetch_books = "SELECT * FROM library ORDER BY publish_date DESC LIMIT $start_from, $results_per_page";
$result = $con->query($sql_fetch_books);

// Start rendering the HTML
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Recent Books</title>";
echo "<link rel='stylesheet' href='style.css'>";
echo "<style>";
echo "body {";
echo "    background-image: url('images5.jpeg');";
echo "    background-repeat: no-repeat;";
echo "    background-size: cover;";
echo "    background-position: center;";
echo "    height: 100vh;";

echo "}";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h1 class='heading'>Recent Books</h1>";

// Check if there are any recent books
if ($result->num_rows > 0) {
    echo "<table class='my-table1'>";

    echo "<tr><th>Title</th><th>Author</th><th>Subject</th><th>Publish Date</th><th>Available</th><th>Action</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["title"]."</td>";
        echo "<td>".$row["author"]."</td>";
        echo "<td>".$row["subject"]."</td>";
        echo "<td>".$row["publish_date"]."</td>";
        echo "<td>".$row["Available"]."</td>"; // Added Available column
        echo "<td><a href='".$_SERVER['PHP_SELF']."?page=".$page."&delete=".$row['Id']."' onclick='return confirm(\"Are you sure you want to delete this book?\")' class='delete-button'>Delete</a></td>";

        echo "</tr>";
    }

    echo "</table>";

    // Pagination links
    $sql_total_records = "SELECT COUNT(*) AS total_records FROM library";
    $result_total_records = $con->query($sql_total_records);
    $row_total_records = $result_total_records->fetch_assoc();
    $total_records = $row_total_records['total_records'];
    $total_pages = ceil($total_records / $results_per_page);

    // Pagination links
    echo "<div class='pagination2'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='".$_SERVER['PHP_SELF']."?page=".$i."' ";
        if ($i == $page) echo "class='active'";
        echo ">".$i."</a>";
    }
    echo "</div>";

} else {
    echo "No recent books found.";
}

echo "<br>";
echo "<a href='admin_dashboard.php' class='ar'>Back to Dashboard</a>";

echo "</body>";
echo "</html>";

// Close the database connection
$con->close();
?>


