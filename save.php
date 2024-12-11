<?php
session_start();
require_once 'db.php'; // Ensure the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Retrieve JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Extract meal data
$user_id = $_SESSION['user_id']; // Get user ID from session
$name = $data['name'] ?? null;
$image = $data['image'] ?? null;
$url = $data['url'] ?? null;
$ingredients = $data['ingredients'] ?? null;

// Validate inputs
if (!$name || !$image || !$url || !$ingredients) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit();
}

// Save to database
try {
    $stmt = $pdo->prepare("INSERT INTO meals (user_id, name, image, url, ingredients) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $name, $image, $url, $ingredients]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
