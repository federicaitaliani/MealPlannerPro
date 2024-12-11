<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true); // Get JSON input

// Validate inputs
if (empty($data['mealName']) || empty($data['ingredients']) || !is_array($data['ingredients'])) {
    echo json_encode(["success" => false, "message" => "Invalid input."]);
    exit();
}

// Serialize ingredients to JSON
$mealName = $conn->real_escape_string($data['mealName']);
$ingredients = $conn->real_escape_string(json_encode($data['ingredients']));

// Insert into shopping_list table
$sql = "INSERT INTO shopping_list (user_id, meal_name, ingredients) VALUES ('$user_id', '$mealName', '$ingredients')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Meal added to shopping list."]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();
?>
