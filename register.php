<?php
include 'db.php'; // Include the database connection file

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        // Sanitize inputs
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);

        // Check if username exists
        $check_sql = "SELECT id FROM users WHERE username = '$username'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo json_encode([
                "success" => false,
                "message" => "Username already exists. <a href='login.html'>Login here</a>.",
            ]);
        } else {
            // Register the user
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode([
                    "success" => true,
                    "message" => "Registration successful!",
                    "login_url" => "login.html"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "An error occurred while registering. Please try again later."
                ]);
            }
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Both username and password fields are required."
        ]);
    }

    $conn->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
