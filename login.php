<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// session_start();
// include 'db.php';

// if (headers_sent($file, $line)) {
//     die("Headers already sent in $file on line $line");
// }

session_start();
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the username input
    $username = $conn->real_escape_string($_POST['username']);

    // Query to fetch the user ID based on the username
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user ID and store it in the session
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id']; 

        // Redirect to the dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Username not found. Please register.";
    }

    $conn->close();
}
?>

<!-- Login Form -->
<form method="POST" action="login.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <button type="submit">Login</button>
</form>
