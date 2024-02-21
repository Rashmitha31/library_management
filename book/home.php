<?php
require_once("config.php");
$con = new mysqli("localhost:3008", "root", "chat", "Book");

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Handle search query
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$filter_criteria = isset($_GET['filter']) ? $_GET['filter'] : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : '';

// Construct SQL query
$sql_fetch_books = "SELECT * FROM library";

if (!empty($search_query)) {
    $sql_fetch_books .= " WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%' OR subject LIKE '%$search_query%' OR publish_date LIKE '%$search_query%'";
}

// Add sorting
if (!empty($sort_by)) {
    if ($sort_by == 'author') {
        // For author sorting, use COLLATE to perform case-insensitive sorting
        $sql_fetch_books .= " ORDER BY author COLLATE utf8mb4_unicode_ci";
    } else {
        $sql_fetch_books .= " ORDER BY $sort_by";
    }
}

// Pagination variables
$results_per_page = 5; // Number of results per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

// Calculate the starting point for the results
$start_from = ($page - 1) * $results_per_page;

// Modify SQL query for pagination
$sql_fetch_books .= " LIMIT $start_from, $results_per_page";

$result = $con->query($sql_fetch_books);

// Start rendering the HTML
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Home Page</title>";
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

echo "<h1 style='text-align:center; margin-top:50px;'>Book store</h1>";

// Search form
echo "<form method='get' style='text-align: center;'>";

echo "<input type='text' name='search' placeholder='Search' value='$search_query' style='margin-top: 60px; text-align:center;'>";
echo "<input type='submit' value='Search'>";
echo "</form>";

// Sorting and filtering options
echo "<form method='get'>";
echo "<label>Sort by:</label>";
echo "<select name='sort'>";
echo "<option value=''>None</option>";
echo "<option value='title' " . ($sort_by == 'title' ? 'selected' : '') . ">Title</option>";
echo "<option value='author' " . ($sort_by == 'author' ? 'selected' : '') . ">Author</option>";
echo "<option value='subject' " . ($sort_by == 'subject' ? 'selected' : '') . ">Subject</option>";
echo "<option value='publish_date' " . ($sort_by == 'publish_date' ? 'selected' : '') . ">Publish Date</option>";
echo "</select>";
echo "<input type='submit' value='Apply'>";
echo "</form>";

// Check if there are any books
if ($result->num_rows > 0) {
    echo "<table class='book-table'>";
    echo "<tr><th>Title</th><th>Author</th><th>Subject</th><th>Publish Date</th><th>Available</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["title"]."</td>";
        echo "<td>".$row["author"]."</td>";
        echo "<td>".$row["subject"]."</td>";
        echo "<td>".$row["publish_date"]."</td>";
        echo "<td>".$row["Available"]."</td>";
        echo "</tr>";
    }

    echo "</table>";

    // Pagination links
    $sql_total_records = "SELECT COUNT(*) AS total_records FROM library";
    $result_total_records = $con->query($sql_total_records);
    $row_total_records = $result_total_records->fetch_assoc();
    $total_records = $row_total_records['total_records'];
    $total_pages = ceil($total_records / $results_per_page);

    echo "<div class='pagination-link2'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='home.php?page=".$i."&search=".$search_query."&filter=".$filter_criteria."&sort=".$sort_by."' ";
        if ($i == $page) echo "class='active'";
        echo ">".$i."</a>";
    }
    echo "</div>";
} else {
    echo "No books found matching the search criteria.";
}

echo "<br>";
echo "<a href='admin_dashboard.php' class='dashboard-link' style='color:black'>Logout</a>";

echo "</body>";
echo "</html>";

// Close the database connection
$con->close();
?>







