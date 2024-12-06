<?php
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Sanitize inputs to prevent SQL injection
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);

        // Insert the user into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        // Execute the query and handle the result
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful! <a href='login.html'>Login here</a>";
        } else {
            if ($conn->errno == 1062) { // Duplicate entry error code
                echo "Error: Username already exists. Please choose a different username.";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Both fields are required.";
    }

    $conn->close(); // Close the database connection
}
?>
