<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >Add Book Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: url('images2.jpeg'); background-repeat: no-repeat; height:100vh; background-size: cover; background-position: center;">
    <h1 class="add" style="color:Black">Add Book Details</h1>

    <?php if (isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } ?>
    
    <form action="process_add_book.php" class="form_add" method="post">
        <div class="field_1 input_1">
            <label for="title" class="label_1">Title:</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div class="field_1 input_1">
            <label for="author" class="label_1">Author:</label>
            <input type="text" name="author" id="author" required>
        </div>

        <div class="field_1 input_1">
            <label for="subject" class="label_1">Subject:</label>
            <input type="text" name="subject" id="subject" required>
        </div>

        <div class="field_1 input_1">
            <label for="publish_date" class="label_1">Publish Date:</label>
            <input type="date" name="publish_date" id="publish_date" required>
        </div>
        <div class="field_1 input_1">
            <label for="publish_date" class="label_1">Books Available:</label>
            <input type="text" name="Books_Available" id="Books_Available" required>
        </div>


        <!-- Add more fields as needed -->

        <div class="field_1">
            <input type="submit" class="btn_1" name="submit" value="Add Book">
        </div>
    </form>
    <br>
    <h2><a href="admin_dashboard.php" class="back">Back to Dashboard</a></h2>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check for errors
            var urlParams = new URLSearchParams(window.location.search);
            var error = urlParams.get('error');
            var errorDiv = document.getElementById('error-message');

            if (error) {
                var errorMessage;
                if (error === 'duplicate') {
                    errorMessage = "Error: Duplicate book entry. Please check the details provided.";
                } else if (error === 'validation') {
                    errorMessage = "Error: Please fill in all required fields.";
                } else if (error === 'database') {
                    errorMessage = "Error: Failed to add book details to the database. Please try again.";
                }
                // Add more conditions as needed

                errorDiv.innerHTML = errorMessage;
                errorDiv.style.display = 'block';
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
        // Check for success or error message
        var urlParams = new URLSearchParams(window.location.search);
        var success = urlParams.get('success');
        var error = urlParams.get('error');

        if (success === 'true') {
            alert('Book details added successfully.');
        } else if (error === 'database') {
            alert('Failed to add book details to the database. Please try again.');
        }
    });
    </script>
</body>
</html>
