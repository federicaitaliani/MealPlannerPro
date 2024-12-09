<?php
include 'db.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Sanitize inputs to prevent SQL injection
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);

        // Check if the username already exists in the database
        $check_sql = "SELECT id FROM users WHERE username = '$username'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            // User already exists
            echo "
                <p>Error: Username already exists.</p>
                <p>
                    <a href='login.html'>Login here</a> or 
                    <a href='register.html'>register with a different username</a>.
                </p>
            ";
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful! <a href='login.html'>Login here</a>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "<p>Both username and password fields are required.</p>";
    }

    $conn->close(); // Close the database connection
}
?>
