<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form data
    $dataFromForm = $_POST['data'];
    echo "Data from form: $dataFromForm";
} else {
    // Display the form
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Combined Page</title>
    </head>
    <body>
        <form method="post">
            <label for="data">Data:</label>
            <input type="text" name="data" required>
            <button type="submit">Submit</button>
        </form>
    </body>
    </html>
    ';
}
?>
