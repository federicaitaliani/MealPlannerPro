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

        // Query to find the user by username
        $sql = "SELECT id, password FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Compare passwords directly
            if ($password === $user['password']) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;

                echo json_encode([
                    "success" => true,
                    "message" => "Login successful. Redirecting...",
                    "redirect" => "index.html"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid password. Please try again."
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Username not found. Please <a href='register.html'>register here</a>."
            ]);
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
?>
