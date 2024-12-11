<?php
session_start();
include 'db.php'; // Ensure the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Retrieve JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Log the received data for debugging
file_put_contents('debug_save_favorites.log', print_r($data, true));

// Extract meal data
$user_id = $_SESSION['user_id']; // Get user ID from session
$name = $data['name'] ?? null;
$image = $data['image'] ?? null;
$url = $data['url'] ?? null;
$ingredients = $data['ingredients'] ?? null;
$calories = $data['calories'] ?? null;
$protein = $data['protein'] ?? null;
$fat = $data['fat'] ?? null;
$carbs = $data['carbs'] ?? null;
$prep_time = $data['prep_time'] ?? null;

// Validate inputs
if (!$name || !$image || !$url || !$ingredients) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit();
}

// Convert ingredients array to JSON for database storage
$ingredients_json = json_encode($ingredients);

// Save to database
try {
    $stmt = $pdo->prepare("INSERT INTO meals (user_id, name, image, url, ingredients) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $name, $image, $url, $ingredients_json]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
