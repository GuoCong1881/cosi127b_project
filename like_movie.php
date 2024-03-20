<?php
// Check if request is POST and data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['movie_id'])) {

    // Connect to the database
    $conn = mysqli_connect("localhost", "username", "password", "database_name");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Extract and sanitize user input (consider further validation)
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $movie_id = (int) $_POST['movie_id']; // Cast to integer for safety

    // Prepare the query to insert a like record
    $sql = "INSERT INTO Likes (uemail, mpid) VALUES (?, ?)";

    // Prepare statement with secure parameter binding
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters to prevent SQL injection
    mysqli_stmt_bind_param($stmt, "si", $email, $movie_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Successfully liked the movie!";
    } else {
        echo "Error liking the movie: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Handle other cases (e.g., invalid request method or missing data)
    echo "Invalid request.";
}