<?php
include 'db.php'; // Include database connection
echo "<br>Connected to database successfully!<br>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Insert the username into the database
    $sql = "INSERT INTO users (username) VALUES ('$username')";
    echo "SQL Query: $sql<br>";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else { 
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); // Close the connection here
}
?>

<form method="POST" action="register.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password:</label>
    <input type="text" id="password" name="password" required><br>
    <button type="submit">Register</button>
</form> 
