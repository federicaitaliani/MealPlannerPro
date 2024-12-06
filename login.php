<?php
session_start();
include 'db.php'; // Include the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Sanitize inputs to prevent SQL injection
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);

        // Query to find the user by username
        $sql = "SELECT id, password FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Since you're not hashing passwords, compare directly
            if ($password === $user['password']) {
                // Store user ID and username in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;

                // Redirect to the dashboard
                header("Location: index.html");
                exit();
            } else {
                echo "Invalid password. Please try again.";
            }
        } else {
            echo "Username not found. Please <a href='register.html'>register here</a>.";
        }
    } else {
        echo "Please fill in all fields.";
    }

    // Close the database connection
    $conn->close();
}
?>
