<?php
include 'db.php'; // Include the database connection file

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Check if both username and password are provided
    if (!empty($username) && !empty($password)) {
        // Sanitize inputs
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);

        // Query to find the user by username
        $sql = "SELECT id, password FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Compare the provided password with the stored one
            if ($password === $user['password']) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;

                // Redirect to the index page after successful login
                header("Location: index2.php");
                exit(); // Ensure no further code is executed after redirect
            } else {
                // If password is incorrect
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid password. Please try again."
                ]);
            }
        } else {
            // If username is not found
            echo json_encode([
                "success" => false,
                "message" => "Username not found. Please <a href='register.html'>register here</a>."
            ]);
        }
    } else {
        // If either username or password is missing
        echo json_encode([
            "success" => false,
            "message" => "Both username and password fields are required."
        ]);
    }

    $conn->close();
} else {
    // If the request method is not POST
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
?>

